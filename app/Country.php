<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $timestamps = false;

    public function cities() {
        return $this->hasMany('App\City');
    }

    public function companies() {
        return $this->hasMany('App\Company');
    }

    public function departments() {
        return $this->hasMany('App\Department');
    }
}
