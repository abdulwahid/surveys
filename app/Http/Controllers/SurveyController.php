<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Role;
use App\SurveyResponse;
use App\SurveyScore;
use App\SurveysTaken;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;


class SurveyController extends Controller
{
    /**
     * Display a form to get information from User.
     *
     * @param  Request  $request
     * @return Response
     */
    public function home()
    {
        return view('survey.home');
    }

    /**
     * Validate Information from user and start survey.
     *
     * @param  Request  $request
     * @return Response
     */
    public function startSurvey(Request $request)
    {

        $coupon = $request->input('coupon');

        if($coupon) {
            $couponData = Coupon::where('coupon', '=', $coupon)->first();
            if($couponData) {

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

                $roles = [];
                if(!$surveyData->role) {
                    $roles = Role::all()->pluck('name', 'id');
                }
                return view('survey.survey-process')->with(['surveyData' => $surveyData, 'roles' => $roles]);

            } else {
                Session::flash('error_message', 'Invalid Coupon. No survey found for provided coupon.');
                return redirect('/')->withInput()->with('error_message', 'Invalid Coupon. No survey found for provided coupon.');
            }
        } else {
            Session::flash('error_message', 'Coupon is required.');
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

                if( $answer['answers_count'] != 4 || ($answer['answers_count'] == 4 && $answer['answer_position'] == 4) ) {

                    if (!isset($data[$response->trait_id]['positions_sum'])) {
                        $data[$response->trait_id]['positions_sum'] = 0;
                    }

                    $data[$response->trait_id]['category_id'] = $answer['category_id'];
                    $data[$response->trait_id]['traits_count'] = $answer['traits_count'];
                    $data[$response->trait_id]['answers_count'] = $answer['answers_count'];
                    $data[$response->trait_id]['questions_count'] = $answer['questions_count'];
                    $data[$response->trait_id]['positions_sum'] += $answer['answer_position'];
                }


            }

        }

        foreach ($data as $trait => $row) {

            $answersCount = $data[$trait]['answers_count'];
            $questionsCount = $data[$trait]['questions_count'];

            if($answersCount != 4) {
                $traitsCount = $data[$trait]['traits_count'];
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
            $surveyScore->trait_id = $trait;
            $surveyScore->category_id = $row['category_id'];
            $surveyScore->score = $score;
            $surveyScore->save();
        }
    }
}
