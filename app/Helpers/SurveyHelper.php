<?php

namespace App\Helpers;

use App\Category;
use App\SurveyResponse;
use App\SurveyScore;
use App\Traits;
use Illuminate\Support\Facades\DB;

class SurveyHelper
{
    /**
     * @param $surveyTakenId
     * @return array
     */
    public function setupGraphData($surveyTakenId) {
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
            $graphData[$i] = '{
                xAxis: {categories: ' . json_encode($traits[$i]) . '},
                yAxis: {max: 100, min:0},
                title: {text: false},
                series: [
                    {
                        name: "Candidate\'s Result",
                        data: [' . implode(',', $averages[$i]) . '],
                        zIndex: 1,
                        marker: {
                            fillColor: "white",
                            lineWidth: 2,
                            lineColor: Highcharts.getOptions().colors[0]
                        }
                    },
                    {
                        name: "Canadian Benchmark",
                        data: [' . implode(',', $ranges[$i]) . '],
                        type: "arearange",
                        lineWidth: 0,
                        linkedTo: ":previous",
                        color: Highcharts.getOptions().colors[0],
                        fillOpacity: 0.3,
                        zIndex: 0
                    }
                ]
            }';
            $i++;
        }

        return $graphData;
    }

    /**
     * @param $surveyTakenId
     * @return string
     */
    public function generatePDF($surveyTakenId) {
        $pdfFile = public_path().'/pdf_files/'.$surveyTakenId.'.pdf';
        $graphData = $this->setupGraphData($surveyTakenId);
        $graphImages = [];
        foreach ($graphData as $graph) {
            $fileName = 'temp/' . time() . '-' . rand(0,999);
            $optionsFile = fopen($fileName . '.json', 'w+');
            fwrite($optionsFile, $graph);
            fclose($optionsFile);
            chmod($fileName . '.json', 0777);

            shell_exec('highcharts-export-server --infile ' . $fileName . '.json' . ' --outfile ' . $fileName. '.png');
            unlink($fileName . '.json');
            $graphImages[] = $fileName. '.png';
        }


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
        $html = view('pdf', ['scores' => $scores, 'categories' => $categoriesData, 'traits' => $traitsData, 'graphImages' => $graphImages]);
        fopen($pdfFile, 'w');
        \PDF::loadHTML($html)->save($pdfFile);

        foreach($graphImages as $image) {
            unlink($image);
        }

        return $pdfFile;
    }
}
