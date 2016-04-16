<?php

namespace App\Http\Controllers\Admin;

use App\SurveysTaken;
use App\Http\Controllers\Controller;


class SurveyController extends Controller
{

    public function surveysTaken()
    {

        $surveysTaken = SurveysTaken::with(['role'])->get();
        return view('admin.surveys-taken', ['surveysTaken'=> $surveysTaken]);
    }
}
