<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Traits extends Model
{
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'traits';

    public function answers() {
        return $this->hasMany('App\Answer', 'trait_id');
    }

    public function surveyResponses() {
        return $this->hasMany('App\SurveyResponse');
    }

    public function surveyScores() {
        return $this->hasMany('App\SurveyScore');
    }
}
