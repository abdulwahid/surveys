<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{

    public $timestamps = false;

    protected $table = 'survey_responses';

    public function surveysTaken() {
        return $this->belongsTo('App\SurveysTaken');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function traits() {
        return $this->belongsTo('App\Traits');
    }

    public function question() {
        return $this->belongsTo('App\Question');
    }

    public function answer() {
        return $this->belongsTo('App\Answer');
    }

}
