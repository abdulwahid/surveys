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
    public function setupAverageGraphData($surveyTakenId) {
        $selectedScores = SurveyScore::with(['traits'])
            ->join('categories as c', 'c.id', '=', 'survey_scores.category_id')
            ->select('survey_scores.*', 'c.name as category_name')
            ->where('survey_scores.surveys_taken_id', '=', $surveyTakenId)
            ->orderBy('c.sort_order')
            ->get();

        $selectedTraits = $selectedScores->keyBy('trait_id')->keys()->all();
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
        $categoryLines = [];
        $categoryLabels = [];
        $selectedScoresByCategories = $selectedScores->groupBy('category_id');
        $graphData = [];
        $traitsCounter = 0;
        $categoriesCounter = 0;
        $categoriesCount = $selectedScoresByCategories->count();
        $prevCategoryLine = 0;

        foreach($selectedScoresByCategories as $categoryId => $scores) {
            foreach($scores as $score) {
                $traitId = $score->trait_id;
                $traits[] = $score->traits->name;
                $averages[] = '["' . $score->traits->name . '",' . $score->score . ']';
                if($allScores->has($traitId)) {
                    $ranges[] = '["' . $allScores[$traitId]->traits->name . '", ' . $allScores[$traitId]->min_score . ',' . $allScores[$traitId]->max_score . ']';
                } else {
                    $ranges[] = '["' . $score->traits->name . '", 0,0]';
                }
                $traitsCounter++;
            }

            $categoryLines[] = [
                'color' => 'grey',
                'dashStyle' => 'longdash',
                'value' => $traitsCounter - 0.5,
                'width' => 1
            ];

            $categoryLabels[] = [
                'from' => $prevCategoryLine - 0.5,
                'to' => $traitsCounter - 0.5,
                'label' => [
                    'text' => $scores->first()->category_name,
                    'verticalAlign' => 'top',
                    'y' => 15

                ],
                'zIndex' => 5
            ];

            $prevCategoryLine = $traitsCounter;
            $categoriesCounter++;
            if($traitsCounter > 15 || $categoriesCount == $categoriesCounter) {
                $categoryLines[count($categoryLines) - 1]['width'] = 0;
                $graphData[] = '{
                    xAxis: {
                        categories: ' . json_encode($traits) . ',
                        plotLines: ' . json_encode($categoryLines) . ',
                        plotBands: ' . json_encode($categoryLabels) . ',
                    },
                    yAxis: {max: 100, min:0},
                    title: {text: false},
                    series: [
                        {
                            name: "Candidate\'s Result",
                            data: [' . implode(',', $averages) . '],
                            zIndex: 1,
                            marker: {
                                fillColor: "white",
                                lineWidth: 2,
                                lineColor: Highcharts.getOptions().colors[0]
                            }
                        },
                        {
                            name: "Canadian Benchmark",
                            data: [' . implode(',', $ranges) . '],
                            type: "arearange",
                            lineWidth: 0,
                            linkedTo: ":previous",
                            color: Highcharts.getOptions().colors[0],
                            fillOpacity: 0.5,
                            zIndex: 0
                        }
                    ]
                }';

                $ranges = [];
                $averages = [];
                $traits = [];
                $categoryLines = [];
                $categoryLabels = [];
                $traitsCounter = 0;
                $prevCategoryLine = 0;
            }
        }

        return $graphData;
    }

    public function setupPercentageGraphsData($surveyScores) {
        $graphData = [];

        foreach($surveyScores as $categoryId => $traitScores) {
            $traits = [];
            $score = [];

            foreach($traitScores as $traitScore) {
                $traits[] = $traitScore->traits->name;
                $score[] = $traitScore->score;
            }

            $graphData[$categoryId] = '{
                chart: {type: "bar"},
                xAxis: {categories: ["'. implode('","', $traits) .'"]},
                yAxis: {min: 0, max: 100},
                tooltip: {valueSuffix: "%"},
                plotOptions: {bar: {dataLabels: {enabled: true, format: "{y}%"}}},
                credits: {enabled: false},
                title: {text: "' . $traitScores->first()->category->name . '"},
                series: [{data: ['. implode(',', $score) .']}]
            }';
        }
        return $graphData;
    }

    public function createGraphImages($graphsData) {
        $graphImages = [];
        foreach ($graphsData as $key => $graph) {
            $fileName = 'temp/' . time() . '-' . rand(0,999);
            $optionsFile = fopen($fileName . '.json', 'w+');
            fwrite($optionsFile, $graph);
            fclose($optionsFile);
            chmod($fileName . '.json', 0777);

            shell_exec('highcharts-export-server --infile ' . $fileName . '.json' . ' --outfile ' . $fileName. '.png');
            unlink($fileName . '.json');
            $graphImages[$key] = $fileName. '.png';
        }
        return $graphImages;
    }

    /**
     * @param $surveyTakenId
     * @return string
     */
    public function generatePDF($surveyTakenId) {
        $pdfFile = public_path().'/pdf_files/'.$surveyTakenId.'.pdf';
        $averageGraphsData = $this->setupAverageGraphData($surveyTakenId);
        $averageGraphImages = $this->createGraphImages($averageGraphsData);

        $surveyScores = SurveyScore::with(['category', 'traits'])->where('surveys_taken_id', $surveyTakenId)->get()->groupBy('category_id');
        $percentageGraphData = $this->setupPercentageGraphsData($surveyScores);
        $percentageGraphImages = $this->createGraphImages($percentageGraphData);

        $html = view('pdf', ['scores' => $surveyScores, 'averageGraphImages' => $averageGraphImages, 'percentageGraphImages' => $percentageGraphImages])->render();
        fopen($pdfFile, 'w');
        \PDF::loadHTML($html)->save($pdfFile);

        foreach($averageGraphImages as $image) {
            unlink($image);
        }

        return $pdfFile;
    }
}