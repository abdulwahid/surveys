<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyScore extends Model
{
    public $timestamps = false;

    protected $table = 'survey_scores';

    public function surveysTaken() {
        return $this->belongsTo('App\SurveysTaken');
    }

    public function traits() {
        return $this->belongsTo('App\Traits');
    }
}
