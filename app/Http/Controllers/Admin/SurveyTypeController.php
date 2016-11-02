<?php

namespace App\Http\Controllers\Admin;

use App\SurveyType;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SurveyTypeController extends Controller
{
    public function showList() {
        $surveyTypes = SurveyType::all();
        return view('admin.surveyType.show-list', compact('surveyTypes'));
    }

    public function create() {
        return view('admin.surveyType.create');
    }

    public function update($id) {
        $surveyType = SurveyType::findOrFail($id);
        return view('admin.surveyType.update', compact('surveyType'));
    }

    public function postUpdate(Request $request, $id=null) {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required'
        ]);

        if($id) {
            $surveyType = SurveyType::findOrFail($id);
            $actionType = 'updated';
        } else {
            $surveyType = New SurveyType;
            $actionType = 'created';
        }

        $surveyType->name = $request->get('name');
        $surveyType->description = $request->get('description');
        $surveyType->save();

        return redirect()->route('admin-survey-types-list')->with(['message' => 'Survey Type ' . $actionType . ' successfully']);
    }

    public function delete($id) {
        $surveyType = SurveyType::findOrFail($id);
        $surveyType->delete();
        return redirect()->route('admin-survey-types-list')->with(['message' => 'Survey Type deleted successfully']);
    }
}
