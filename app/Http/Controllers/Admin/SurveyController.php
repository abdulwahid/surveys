<?php

namespace App\Http\Controllers\Admin;

use App\SurveyScore ;
use App\SurveysTaken;
use App\Http\Controllers\Controller;
use DB;

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
        foreach($selectedTraits as $traitId) {
            $traits[] = $selectedScores[$traitId]->traits->name;
            $averages[] = '["' . $selectedScores[$traitId]->traits->name . '",' . $selectedScores[$traitId]->score . ']';
            if($allScores->has($traitId)) {
                $ranges[] = '["' . $allScores[$traitId]->traits->name . '", ' . $allScores[$traitId]->min_score . ',' . $allScores[$traitId]->max_score . ']';
            } else {
                $ranges[] = '["' . $selectedScores[$traitId]->traits->name . '", 0,0]';
            }
        }

        $ranges = '[' . implode(',', $ranges) . ']';
        $averages = '[' . implode(',', $averages) . ']';

        return view('admin.generate-graph', ['traits' => $traits, 'ranges' => $ranges, 'averages' => $averages]);
    }

}
