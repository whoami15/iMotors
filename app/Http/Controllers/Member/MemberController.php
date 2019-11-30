<?php

namespace App\Http\Controllers\Member;

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

class MemberController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth');
        $this->middleware('member');
    }

    public function getMemberDashboard() {

        $user = Auth::user();
        $applications = $user->application()->orderBy('created_at','DESC')->take(5)->get();
        
        return view('member.dashboard')
            ->with('user',$user)
            ->with('applications',$applications);      
    }

    public function getMemberDashboardData(Request $request) {

        if ($request->wantsJson()) {
             
            $user = Auth::user();       
            
            $summary = getDashboardCounts($user->id);
            $variable = Application::where('user_id',$user->id)->count();

            return response()->json([
                'summary' => $summary,
                'variable' => $variable
            ],200);
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function getMemberApplications() {

        $user = Auth::user();
        
        return view('member.application.history')->with('user',$user);      
    }

    public function getMemberApplicationsData(Request $request) {

        if ($request->wantsJson()) {

            $user = Auth::user();
    
            $referrals = Application::where('user_id',$user->id)->orderBy('created_at','DESC');
            
            if($referrals) {

                return Datatables::of($referrals)
                ->editColumn('name', function ($referrals) {
                    return ucwords($referrals->full_name);
                })
                ->editColumn('username', function ($referrals) {
                    return $referrals->username; 
                })
                ->addColumn('details', function ($referrals) {
                    return $referrals->mobile;
                })
                ->editColumn('status', function ($referrals) {
                    if($referrals->active == 1){
                        return '<span class="label label-success">PREMIUM</span>';
                    } elseif($referrals->active == 0) {
                        return '<span class="label label-danger">INACTIVE</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('date', function ($referrals) {
                    return date('F j, Y g:i a', strtotime($referrals->created_at)) . ' | ' . $referrals->created_at->diffForHumans();
                })
                ->addIndexColumn()
                ->rawColumns(['name','username','mobile','status','date'])
                ->make(true);

            }else{

                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again.'),422);
            }

        } else{

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

}
