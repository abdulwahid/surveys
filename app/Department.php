<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $timestamps = false;

    public function company() {
        return $this->belongsTo('App\Company');
    }

    public function country() {
        return $this->belongsTo('App\Country');
    }

    public function city() {
        return $this->belongsTo('App\City');
    }

    public function coupons() {
        return $this->hasMany('App\Coupon');
    }
}
