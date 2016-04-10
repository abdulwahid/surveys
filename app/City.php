<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;

    public function country() {
        return $this->belongsTo('App\Country');
    }

    public function companies() {
        return $this->hasMany('App\Company');
    }

    public function departments() {
        return $this->hasMany('App\Department');
    }
}
