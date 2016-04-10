<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    public function question() {
        return $this->belongsTo('App\Question');
    }

    public function traits() {
        return $this->belongsTo('App\Traits', 'trait_id');
    }

    public function surveyResponses() {
        return $this->hasMany('App\SurveyResponse');
    }

}
