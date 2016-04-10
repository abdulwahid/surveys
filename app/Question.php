<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function answers() {
        return $this->hasMany('App\Answer');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function surveys() {
        return $this->belongsToMany('App\Survey');
    }

    public function surveyResponses() {
        return $this->hasMany('App\SurveyResponse');
    }
}
