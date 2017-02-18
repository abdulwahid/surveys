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

        $selectedScores = SurveyScore::with(['traits'])
            ->join('categories as c', 'c.id', '=', 'survey_scores.category_id')
            ->select('survey_scores.*')
            ->where('survey_scores.surveys_taken_id', '=', $surveyTakenId)
            ->orderBy('c.sort_order')
            ->get()
            ->keyBy('trait_id');

        $selectedTraits = $selectedScores->keys()->all();

        $allScores = SurveyScore::with(['traits'])
            ->join('categories as c', 'c.id', '=', 'survey_scores.category_id')
            ->select('survey_scores.id', 'survey_scores.trait_id', DB::raw('MAX(survey_scores.score) as max_score, MIN(survey_scores.score) as min_score'))
            ->where('surveys_taken_id', '!=', $surveyTakenId)
            ->whereIn('survey_scores.trait_id', $selectedTraits)
            ->groupBy('survey_scores.trait_id')
            ->orderBy('c.sort_order')
            ->get()
            ->keyBy('trait_id');

        $ranges = [];
        $averages = [];
        $traits = [];

        foreach($selectedTraits as $traitId) {
            $traits[] = $selectedScores[$traitId]->traits->name;
            $averages[] = '["' . $selectedScores[$traitId]->traits->name . '",' . $selectedScores[$traitId]->score . ']';
            if($allScores->has($traitId)) {
                $ranges[] = '["' . $allScores[$traitId]->traits->name . '", ' . $allScores[$traitId]->min_score . ',' . $allScores[$traitId]->max_score . ']';
            } else {
                $ranges[] = '["' . $selectedScores[$traitId]->traits->name . '", 0,0]';
            }
        }

        $ranges = array_chunk($ranges, 15);
        $averages = array_chunk($averages, 15);
        $traits = array_chunk($traits, 15);

        $i = 0;
        $graphData = [];
        foreach($ranges as $range) {
            $graphData[$i]['traits'] = $traits[$i];
            $graphData[$i]['ranges'] = '[' . implode(',', $ranges[$i]) . ']';
            $graphData[$i]['averages'] = '[' . implode(',', $averages[$i]) . ']';
            $i++;
        }

        $graphData = $surveyHelper->setupGraphData($surveyTakenId);
        return view('admin.generate-graph', ['graphData' => $graphData]);
    }

    public function downloadReport(SurveyHelper $surveyHelper, $surveyTakenId) {
        $pdfFile = public_path().'/pdf_files/'.$surveyTakenId.'.pdf';
        if(File::exists($pdfFile)) {
            $surveyHelper->generatePDF($surveyTakenId);
        }
        $headers = ['Content-Type' => 'application/pdf'];
        return response()->download($pdfFile, 'Report-' . $surveyTakenId . '.pdf', $headers);
    }
}
