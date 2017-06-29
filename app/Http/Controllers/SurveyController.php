<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Helpers\SurveyHelper;
use App\Role;
use App\SurveyResponse;
use App\SurveyScore;
use App\SurveysTaken;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


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
     * @param  SurveyHelper  $surveyHelper
     */
    public function saveSurveyResponse(Request $request, SurveyHelper $surveyHelper)
    {
        //@todo optimize logic of this function

        $inputs = $request->input();
        $surveyTaken = new SurveysTaken();
        $surveyTaken->coupon_id = $inputs['coupon_id'];
        $surveyTaken->user_name = $inputs['user_name'];
        $surveyTaken->user_email = $inputs['user_email'];
        $surveyTaken->role_id = $inputs['role'];
        $surveyTaken->save();
        $surveyTakenId = $surveyTaken->id;

        $data = [];
        $surveyResponses = [];

        foreach($inputs['responses'] as $answer) {

            $surveyResponses[] = [
                'surveys_taken_id' => $surveyTakenId,
                'category_id' => $answer['category_id'],
                'trait_id' => ($answer['trait_id']) ? $answer['trait_id'] : NULL,
                'question_id' => $answer['question_id'],
                'answer_id' => $answer['answer_id'],
                'answer_position' => $answer['answer_position'],
            ];

            if ($answer['trait_id']) {

                if (!isset($data[$answer['trait_id']]['positions_sum'])) {
                    $data[$answer['trait_id']]['positions_sum'] = 0;
                }

                $data[$answer['trait_id']]['category_id'] = $answer['category_id'];
                $data[$answer['trait_id']]['traits_count'] = $answer['traits_count'];
                $data[$answer['trait_id']]['answers_count'] = $answer['answers_count'];
                $data[$answer['trait_id']]['questions_count'] = $answer['questions_count'];

                $minMarks = 1;
                $maxMarks = $answer['answers_count'];
                if($answer['trait_occurrence'] > 1) {
                    for($i=1; $i<$answer['trait_occurrence']; $i++) {
                        $maxMarks--;
                        $minMarks++;
                    }
                }
                $data[$answer['trait_id']]['max_marks'][$answer['question_id']] = $maxMarks;
                $data[$answer['trait_id']]['min_marks'][$answer['question_id']] = $minMarks;
                $data[$answer['trait_id']]['positions_sum'] += $answer['answer_position'];
            }
        }

        SurveyResponse::insert($surveyResponses);

        $surveyScores = [];
        foreach ($data as $traitId => $row) {

            $minMarks = array_sum($row['min_marks']);
            $maxMarks = array_sum($row['max_marks']);

            $scaleRange = $maxMarks - $minMarks;
            $scoreValue = $row['positions_sum'] - $minMarks;
            $scoreValue = $scoreValue > 0 ? $scoreValue : 0;
            $scoreValue = $scoreValue < 100 ? $scoreValue : 100;
            $score = round($scoreValue / $scaleRange * 100);

            $surveyScores[] = [
                'surveys_taken_id' => $surveyTakenId,
                'trait_id' => $traitId,
                'category_id' => $row['category_id'],
                'score' => $score
            ];
        }

        SurveyScore::insert($surveyScores);
        $pdfFile = $surveyHelper->generatePDF($surveyTakenId);

        // send PDF report in EMail
        Mail::send('emails.survey-report', ['name' => 'Admin', 'candidate_name' => $inputs['user_name']], function ($mail) use ($pdfFile, $inputs) {
            $mail->from('surveys@languageofintention.com', 'Surveys');
            $mail->to(env('ADMIN_EMAIL'), 'Surveys')->subject('Survey Report');
            $mail->attach($pdfFile);
        });

    }
}
