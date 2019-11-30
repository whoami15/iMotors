<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use App\Models\User;
use App\Models\Application;
use Session;
use Redirect;
use Cache;
use Hash;
use DB;
use PDF;
use URL;
use DateTime;

class AdminController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function getAdminDashboard() {

        $user = Auth::user();
        $applications = Application::with('user')->where('status','PENDING')->orderBy('created_at','DESC')->take(5)->get();
        
        return view('admin.dashboard')
            ->with('user',$user)
            ->with('applications',$applications);
    }

    public function getAdminDashboardData(Request $request) {

        if ($request->wantsJson()) {
             
            $user = Auth::user();

            $total_users = User::where('role',1)->count();
            $total_users_active = User::where('role',1)->where('active',1)->count();
            $total_booking_count = Booking::where('status','CONFIRMED')->count();
            $total_eloading_count = EloadingCharge::where('status',1)->count();
            $total_booking = Booking::where('status','CONFIRMED')->sum('total_fare');
            $total_eloading = EloadingCharge::where('status',1)->sum('amount');
            $total_transferred_masterfund = MasterFund::sum('total');
            $total_converterted_bookingfund = ServicesFund::where('fund_type','TNT')->sum('amount');
            $total_converterted_eloadingfund = ServicesFund::where('fund_type','LOAD')->sum('amount');

            return response()->json([
                'total_users' => $total_users, 
                'total_users_active' => $total_users_active, 
                'total_booking_count' => $total_booking_count, 
                'total_eloading_count' => $total_eloading_count, 
                'total_booking' => $total_booking, 
                'total_eloading' => $total_eloading, 
                'total_transferred_masterfund' => $total_transferred_masterfund, 
                'total_converterted_bookingfund' => $total_converterted_bookingfund, 
                'total_converterted_eloadingfund' => $total_converterted_eloadingfund
            ],200);
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function getAdminApplications() {

        $user = Auth::user();
        
        return  view('admin.application')->with('user',$user);      
    }

    public function getAdminApplicationsData(Request $request) {

        if ($request->wantsJson()) {
                
            if($username = $request->username) {

                $members = User::where('role',1)->where('username', $username)->orderBy('created_at','DESC')->get();
            } else if($name = $request->name) {

                $search = '%'.$name.'%';

                $members = User::where('role',1)->where(DB::raw('concat(first_name," ",last_name)') , 'LIKE' , $search)->orderBy('created_at','DESC')->get();

            } else {
                $members = User::where('role',1)->orderBy('created_at','DESC')->take(200)->get();
            }

            return response()->json(['members'=> $members],200); 
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

}
