<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Payment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_payments';

    protected $dates = [
        'payment_date'
    ];
    
    
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function application()
	{
        return $this->belongsTo('App\Models\Application', 'application_id', 'id')->orderBy('id', 'ASC');
    }

}
