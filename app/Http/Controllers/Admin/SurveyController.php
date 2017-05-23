<?php

namespace App\Http\Controllers\Admin;
use App\Helpers\SurveyHelper;
use Illuminate\Http\Request;

use App\Coupon;
use App\Question;
use App\Survey;
use App\SurveyScore ;
use App\SurveysTaken;
use App\Http\Controllers\Controller;
use App\SurveyType;
use DB;
use Illuminate\Support\Facades\File;

class SurveyController extends Controller
{

    public function showList()
    {
        $surveys = Survey::all();
        return view('admin.survey.show-list', compact('surveys'));
    }

    public function create()
    {
        $surveyTypes = SurveyType::all();
        $coupons = Coupon::all();
        $questions = Question::all();
        return view('admin.survey.create', compact('surveyTypes', 'coupons', 'questions'));
    }

    public function update($id)
    {
        $survey = Survey::findOrFail($id);
        $surveyTypes = SurveyType::all();
        $coupons = Coupon::all();
        $questions = Question::all();
        return view('admin.survey.update', compact('survey', 'surveyTypes', 'coupons', 'questions'));
    }

    public function postUpdate(Request $request, $id=null)
    {
        $this->validate($request, [
            'coupons' => 'array',
            'questions' => 'array',
            'title' => 'required',
            'survey_type' => 'required|exists:survey_types,id'
        ]);

        if($id) {
            $survey = Survey::findOrFail($id);
            $actionType = 'updated';
        } else {
            $survey = New Survey;
            $actionType = 'created';
        }

        $survey->title = $request->get('title');
        $survey->description = $request->get('description', '');
        $survey->survey_type_id = $request->get('survey_type');
        $survey->save();

        $survey->coupons()->detach();
        $survey->coupons()->attach($request->get('coupons'));
        $survey->questions()->detach();
        $survey->questions()->attach($request->get('questions'));

        return redirect()->route('admin-surveys-list')->with(['message' => 'Survey ' . $actionType . ' successfully']);
    }

    public function delete($id) {
        $survey = Survey::findOrFail($id);
        $survey->delete();
        return redirect()->route('admin-surveys-list')->with(['message' => 'Survey Deleted Successfully']);
    }

    public function surveysTaken()
    {
        $surveysTaken = SurveysTaken::with(['role'])->get();
        return view('admin.surveys-taken', ['surveysTaken'=> $surveysTaken]);
    }

    public function generateGraph(SurveyHelper $surveyHelper, $surveyTakenId)
    {
        $graphData = $surveyHelper->setupAverageGraphData($surveyTakenId);
        return view('admin.generate-graph', ['graphData' => $graphData]);
    }

    public function downloadReport(SurveyHelper $surveyHelper, $surveyTakenId) {
        $pdfFile = public_path().'/pdf_files/'.$surveyTakenId.'.pdf';
        if(!File::exists($pdfFile)) {
            $surveyHelper->generatePDF($surveyTakenId);
        }
        $headers = ['Content-Type' => 'application/pdf'];
        return response()->download($pdfFile, 'Report-' . $surveyTakenId . '.pdf', $headers);
    }
}
