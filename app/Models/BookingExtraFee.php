<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingExtraFee extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_booking_extra_fee';

    public function user(){
		 return $this->belongsTo('App\Models\User', 'user_id', 'id');
	}

    public function booking(){
		 return $this->belongsTo('App\Models\Booking', 'booking_id', 'id');
	}

}
