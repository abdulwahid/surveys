<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\SurveyResponse;
use App\SurveyScore ;
use App\SurveysTaken;
use App\Http\Controllers\Controller;
use App\Traits;
use DB;
use Illuminate\Support\Facades\File;

class SurveyController extends Controller
{

    public function surveysTaken()
    {
        $surveysTaken = SurveysTaken::with(['role'])->get();
        return view('admin.surveys-taken', ['surveysTaken'=> $surveysTaken]);
    }

    public function generateGraph($surveyTakenId)
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

        return view('admin.generate-graph', ['graphData' => $graphData]);
    }

    public function downloadReport($surveyTakenId) {
        $pdfFile = public_path().'/pdf_files/'.$surveyTakenId.'.pdf';

        // Create PDF Report if not exists
        if(!File::exists($pdfFile)) {
            $surveyData = SurveyResponse::where('surveys_taken_id', $surveyTakenId)->get();
            $categories = $surveyData->pluck('category_id');
            $traits = $surveyData->pluck('trait_id');

            $scores = [];
            $surveyScores = SurveyScore::where('surveys_taken_id', $surveyTakenId)->get();
            foreach($surveyScores as $surveyScore) {
                $scores[$surveyScore->category_id][$surveyScore->trait_id] = $surveyScore->score;
            }

            $categoriesData = Category::select(['id', 'name', 'description'])->whereIn('id', $categories)->get()->keyBy('id');
            $traitsData = Traits::select(['id', 'name', 'description'])->whereIn('id', $traits)->get()->keyBy('id');
            $html = view('pdf', ['scores' => $scores, 'categories' => $categoriesData, 'traits' => $traitsData]);
            fopen($pdfFile, 'w');
            \PDF::loadHTML($html)->save($pdfFile);
        }

        $headers = ['Content-Type' => 'application/pdf'];
        return response()->download($pdfFile, 'Report-' . $surveyTakenId . '.pdf', $headers);
    }
}
