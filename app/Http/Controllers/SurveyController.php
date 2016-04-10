<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Role;
use App\SurveyResponse;
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

        $couponData = Coupon::where('coupon', '=', $coupon)->first();

        if($coupon) {
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
        $input = $request->input();

        $surveyTaken = new SurveysTaken();

        $surveyTaken->coupon_id = $input['coupon_id'];
        $surveyTaken->user_name = $input['user_name'];
        $surveyTaken->user_email = $input['user_email'];
        $surveyTaken->role_id = $input['role'];

        $surveyTaken->save();

        $surveyTakenId = $surveyTaken->id;

        foreach($input['responses'] as $answer) {
            $response = new SurveyResponse();
            $response->surveys_taken_id	= $surveyTakenId;
            $response->category_id	= $answer['category_id'];
            $response->trait_id	= ($answer['trait_id']) ? $answer['trait_id'] : NULL;
            $response->question_id	= $answer['question_id'];
            $response->answer_id = $answer['answer_id'];
            $response->answer_position = $answer['answer_position'];
            $response->save();
        }
    }
}
