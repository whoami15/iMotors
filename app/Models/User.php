<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    protected $table = 'tbl_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'first_name', 'last_name', 'mobile', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['full_name'];

    /**
     * Get the user's full name.
     *
     * @return string
     */

    public function getFullNameAttribute(){
        return "{$this->first_name} {$this->last_name}";
    }

    public function products(){
        return $this->hasMany('App\Models\Products', 'user_id', 'id');
    }

    public function application(){
        return $this->hasMany('App\Models\Application', 'user_id', 'id');
    }

    public function payment(){
        return $this->hasMany('App\Models\Payment', 'user_id', 'id');
    }
}
