<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;

    public function coupons() {
        return $this->hasMany('App\Coupon');
    }

    public function surveysTaken() {
        return $this->hasMany('App\SurveysTaken');
    }
}
