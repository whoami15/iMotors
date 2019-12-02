<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Products extends Model
{

    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_products';

    /**
     * Scope a query to only include active products.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function photos()
	{
        return $this->hasMany('App\Models\Photos', 'product_id', 'id')->orderBy('id', 'ASC');
    }
    
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function application()
	{
        return $this->hasMany('App\Models\Applications', 'product_id', 'id')->orderBy('id', 'ASC');
    }

}
