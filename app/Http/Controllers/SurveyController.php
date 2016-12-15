<?php

namespace App\Http\Controllers;

use App\Category;
use App\Coupon;
use App\Role;
use App\SurveyResponse;
use App\SurveyScore;
use App\SurveysTaken;
use App\Traits;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;



class SurveyController extends Controller
{
    /**
     * Validate Input Coupon from user and start survey.
     *
     * @param  Request  $request
     * @return Response
     */
    public function startSurvey(Request $request)
    {
        $coupon = $request->input('coupon', null);
        if($coupon) {
            $surveyData = Coupon::with(['role', 'surveys' => function ($query) {
                $query->with(['questions' => function ($query) {
                    $query->orderBy('sort_order')
                        ->with(['category', 'answers' => function ($query) {
                            $query->orderBy('sort_order')
                                ->with(['traits']);
                        }]);
                }]);
            }])
            ->where('coupon', '=', $coupon)
            ->first();
    
            if($surveyData) {
                 if($surveyData->surveys->first()) {
                    $roles = [];
                    if(!$surveyData->role) {
                        $roles = Role::all()->pluck('name', 'id');
                    }
                    return view('survey.survey-process')->with(['surveyData' => $surveyData, 'roles' => $roles]);
                } else {
                    return redirect('/')->withInput()->with('error_message', 'No survey found for provided coupon.');
                }
            } else {
                return redirect('/')->withInput()->with('error_message', 'Invalid Coupon.');
            }
        } else {
            return redirect('/')->withInput()->with('error_message', 'Coupon is required.');
        }
    }

    /**
     * save survey response.
     *
     * @param  Request  $request
     * @return Response
     */
    public function saveSurveyResponse(Request $request)
    {
        $inputs = $request->input();

        $surveyTaken = new SurveysTaken();
        $surveyTaken->coupon_id = $inputs['coupon_id'];
        $surveyTaken->user_name = $inputs['user_name'];
        $surveyTaken->user_email = $inputs['user_email'];
        $surveyTaken->role_id = $inputs['role'];
        $surveyTaken->save();

        $surveyTakenId = $surveyTaken->id;
        $data = [];

        foreach($inputs['responses'] as $answer) {

            $response = new SurveyResponse();
            $response->surveys_taken_id	= $surveyTakenId;
            $response->category_id	= $answer['category_id'];
            $response->trait_id	= ($answer['trait_id']) ? $answer['trait_id'] : NULL;
            $response->question_id	= $answer['question_id'];
            $response->answer_id = $answer['answer_id'];
            $response->answer_position = $answer['answer_position'];
            $response->save();


            if ($answer['trait_id']) {

                if (!isset($data[$response->trait_id]['positions_sum'])) {
                    $data[$response->trait_id]['positions_sum'] = 0;
                }

                $data[$response->trait_id]['category_id'] = $answer['category_id'];
                $data[$response->trait_id]['traits_count'] = $answer['traits_count'];
                $data[$response->trait_id]['answers_count'] = $answer['answers_count'];
                $data[$response->trait_id]['questions_count'] = $answer['questions_count'];

                if( $answer['answers_count'] != 4 || ($answer['answers_count'] == 4 && $answer['answer_position'] == 4) ) {
                        $data[$response->trait_id]['positions_sum'] += $answer['answer_position'];
                }
            }
        }

        $scores = [];
        foreach ($data as $traitId => $row) {
            $answersCount = $data[$traitId]['answers_count'];
            $questionsCount = $data[$traitId]['questions_count'];

            if($answersCount != 4) {
                $traitsCount = $data[$traitId]['traits_count'];
                $minMarks = $questionsCount;
                $maxMarks = $questionsCount * $answersCount;
                $secondMaxMarks = $questionsCount * ($answersCount - 1);
                $secondMinMarks = $questionsCount * 2;

                $maxPossible = $maxMarks;
                $minPossible = $minMarks;

                if ($traitsCount < 4) {
                    $maxPossible = $maxMarks + $secondMaxMarks;
                    $minPossible = $minMarks + $secondMinMarks;
                }

                $scaleRange = $maxPossible - $minPossible;
                $scoreValue = $row['positions_sum'] - $minPossible;
                $scoreValue = $scoreValue > 0 ? $scoreValue : 0;
                $scoreValue = $scoreValue < 100 ? $scoreValue : 100;
                $score = round($scoreValue / $scaleRange * 100);

            } else {
                $score = round($row['positions_sum'] / ($questionsCount * 4) * 100);
            }

            $surveyScore = new SurveyScore();
            $surveyScore->surveys_taken_id = $surveyTakenId;
            $surveyScore->trait_id = $traitId;
            $surveyScore->category_id = $row['category_id'];
            $surveyScore->score = $score;
            $surveyScore->save();

            // following Code line used to send PDF in EMail
            $scores[$row['category_id']][$traitId] = $score;
        }

        $categories = array_keys($scores);
        $categoriesData = Category::select(['id', 'name', 'description'])->whereIn('id', $categories)->get()->keyBy('id');
        $traits = array_keys($data);
        $traitsData = Traits::select(['id', 'name', 'description'])->whereIn('id', $traits)->get()->keyBy('id');
        $html = view('pdf', ['scores' => $scores, 'categories' => $categoriesData, 'traits' => $traitsData]);
        $pdfFile = public_path().'/pdf_files/'.$surveyTakenId.'.pdf';
        fopen($pdfFile, 'w');
        \PDF::loadHTML($html)->save($pdfFile);

        /*
        // Code to send PDF in EMail
        Mail::send('emails.survey-report', ['name' => $inputs['user_name']], function ($m) use ($pdfFile, $inputs) {
            $m->from('surveys@languageofintention.com', 'Surveys');
            $m->to($inputs['user_email'], 'Wahid')->subject('Survey Report!');
            $m->attach($pdfFile);
        });
        */

    }
}
