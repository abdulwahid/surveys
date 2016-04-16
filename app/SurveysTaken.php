<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveysTaken extends Model
{
    protected $table = 'surveys_taken';

    public function coupon() {
        return $this->belongsTo('App\Coupon');
    }

    public function surveyResponses() {
        return $this->hasMany('App\SurveyResponse');
    }

    public function surveyScores() {
        return $this->hasMany('App\SurveyScore');
    }

    public function role() {
        return $this->belongsTo('App\Role');
    }
}
