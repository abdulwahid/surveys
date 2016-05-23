<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyScore extends Model
{
    public $timestamps = false;

    protected $table = 'survey_scores';

    public function surveysTaken() {
        return $this->belongsTo('App\SurveysTaken', 'surveys_taken_id');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function traits() {
        return $this->belongsTo('App\Traits', 'trait_id');
    }
}
