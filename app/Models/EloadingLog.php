<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EloadingLog extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_eloading_logs';
	
	public function user(){
		 return $this->belongsTo('App\User', 'user', 'id');
	}
	
}
