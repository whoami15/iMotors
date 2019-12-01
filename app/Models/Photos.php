<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_photos';

    public function post()
    {
        return $this->belongsTo('App\Models\Products', 'product_id', 'id');
    }

}
