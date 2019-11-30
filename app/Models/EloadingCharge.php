<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EloadingCharge extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_eloading_charge';


    public function user(){
		 return $this->belongsTo('App\Models\User', 'user_id', 'id');
	}
}
