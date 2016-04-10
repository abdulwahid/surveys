<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveysTaken extends Model
{
    protected $table = 'surveys_taken';

    public function surveys() {
        return $this->belongsTo('App\Survey');
    }

    public function coupons() {
        return $this->belongsTo('App\Coupon');
    }

    public function surveyResponses() {
        return $this->hasMany('App\SurveyResponse');
    }

    public function surveyScores() {
        return $this->hasMany('App\SurveyScore');
    }
}
