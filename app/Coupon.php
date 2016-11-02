<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public function surveys() {
        return $this->belongsToMany('App\Survey');
    }

    public function role() {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function company() {
        return $this->belongsTo('App\Company', 'company_id', 'id');
    }

    public function department() {
        return $this->belongsTo('App\Department', 'department_id', 'id');
    }

    public function surveysTaken() {
        return $this->hasMany('App\SurveysTaken');
    }
}
