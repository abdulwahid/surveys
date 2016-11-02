<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyType extends Model
{
    public $timestamps = false;

    public function categories() {
        return $this->hasMany('App\Category');
    }

    public function surveys() {
        return $this->hasMany('App\Survey');
    }

}
