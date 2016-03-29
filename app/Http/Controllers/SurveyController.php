<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SurveyController extends Controller
{
    /**
     * Display a form to get information from User.
     *
     * @param  Request  $request
     * @return Response
     */
    public function userInfo()
    {
        return view('survey.user-info');
    }

    /**
     * Display a form to get information from User.
     *
     * @param  Request  $request
     * @return Response
     */
    public function validateUserInfo()
    {
        return view('survey.user-info');
    }
}
