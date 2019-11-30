<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingReward extends Model
{

    protected $table = 'tbl_booking_reward';
	
	public function user(){
		 return $this->belongsTo('App\Models\User', 'user', 'id');
	}
	
}
