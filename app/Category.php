<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    public function questions() {
        return $this->hasMany('App\Question');
    }

    public function traits() {
        return $this->hasMany('App\Traits');
    }

    public function surveyResponses() {
        return $this->hasMany('App\SurveyResponse');
    }
}
