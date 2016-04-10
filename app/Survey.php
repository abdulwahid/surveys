<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    public function coupons() {
        return $this->belongsToMany('App\Coupon');
    }

    public function questions() {
        return $this->belongsToMany('App\Question');
    }

    public function surveysTaken() {
        return $this->hasMany('App\SurveysTaken');
    }
}
