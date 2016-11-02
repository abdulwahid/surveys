<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $timestamps = false;

    public function country() {
        return $this->belongsTo('App\Country');
    }

    public function city() {
        return $this->belongsTo('App\City');
    }

    public function departments() {
        return $this->hasMany('App\Department');
    }

    public function coupons() {
        return $this->hasMany('App\Coupon');
    }
}
