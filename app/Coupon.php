<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public function surveys() {
        return $this->belongsToMany('App\Survey');
    }

    public function role() {
        return $this->belongsTo('App\Role');
    }

    public function department() {
        return $this->belongsTo('App\Department');
    }

    public function surveysTaken() {
        return $this->hasMany('App\SurveysTaken');
    }
}
