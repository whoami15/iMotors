<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{

    protected $table = 'tbl_application';

    //protected $appends = ['extra_fee_sum'];

    //public function getExtraFeeSumAttribute()
    //{
    //	return (int)$this->extra_fee()->sum('amount');
    //}
      
	
	public function user(){
		return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    
    public function product(){
        return $this->belongsTo('App\Models\Products', 'product_id', 'id');
    }

    public function payment(){
        return $this->belongsTo('App\Models\Payment', 'application_id', 'id');
    }

	//public function extra_fee(){
    //    return $this->hasMany('App\Models\BookingExtraFee', 'booking_id', 'id');
    //}
	
}
