<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{

    protected $table = 'tbl_application';

    //protected $appends = ['extra_fee_sum'];

    //public function getExtraFeeSumAttribute()
    //{
    //	return (int)$this->extra_fee()->sum('amount');
    //}
    
    protected $dates = [
        'last_payment_date'
    ];
	
	public function user(){
		return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    
    public function product(){
        return $this->belongsTo('App\Models\Products', 'product_id', 'id');
    }

    public function payment(){
        return $this->hasMany('App\Models\Payment', 'application_id', 'id');
    }

	public static function salesAnalytics()
    {
        return static::selectRaw('SUM(down_payment) as total')
            ->selectRaw('COUNT(*) as total_orders')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('status', 'APPROVED')
            ->selectRaw('EXTRACT(DAY FROM created_at) as day')
            ->selectRaw('DATE_FORMAT(created_at, "%W") as a')
            ->groupBy(DB::raw('EXTRACT(DAY FROM created_at)'))
            ->orderby('day')
            ->get();
    }

    public static function totalSalesMonth()
    {
        $data = static::select(DB::raw('sum(down_payment) as `total`'), DB::raw('created_at as `full_date`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->where('status', 'APPROVED')
            ->groupby('year','month')
            ->get();
        return $data;
    }

    public static function totalSalesYear()
    {
        $data = static::select(DB::raw('sum(down_payment) as `total`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->where('status', 'APPROVED')
            ->groupby('year')
            ->get();
        return $data;
    }
	
}
