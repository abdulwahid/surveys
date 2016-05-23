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
            ->where('surveys_taken_id', '=', $surveyTakenId)->get()->keyBy('trait_id');

        $selectedTraits = $selectedScores->keys()->all();

//        echo '<pre>'; print_r($selectedScores); die;

//        foreach($selectedRawScores as $score) {
//            $selectedTraits[] = $score->trait->id;
//            $selectedScores[$score->trait->id] = $score;
////            $averages[] = [$score->trait->name, $score->score];
//        }

        $allScores = SurveyScore::with(['traits'])
            ->select('id', 'trait_id', DB::raw('MAX(score) as max_score, MIN(score) as min_score'))
            ->where('surveys_taken_id', '!=', $surveyTakenId)
            ->whereIn('trait_id', $selectedTraits)
            ->groupBy('trait_id')
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
                $ranges[] = '["' . $allScores[$traitId]->traits->name . '", 0,0]';
            }
        }

        $ranges = '[' . implode(',', $ranges) . ']';
        $averages = '[' . implode(',', $averages) . ']';

        return view('admin.generate-graph', ['traits' => $traits, 'ranges' => $ranges, 'averages' => $averages]);
    }

}
