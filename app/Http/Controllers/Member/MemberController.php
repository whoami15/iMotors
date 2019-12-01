<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use App\Models\User;
use App\Models\Application;
use App\Models\Products;
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

    public function getMemberApplication(Request $request) {

        if($request->has('product')){

            $check_product = Products::where('id',$request->product)->first();
            
            if($check_product) {

                $products = Products::get();

                return view('member.application.apply')
                    ->with('product',$check_product)
                    ->with('products',$products);
            } else {

                return redirect('/application');
            }
        } else {

            $user = Auth::user();
            
            $products = Products::get();

            return view('member.application.apply')
                ->with('user',$user)
                ->with('products',$products);
        }
    }

    public function getMemberApplications() {

        $user = Auth::user();
        
        return view('member.application.list')->with('user',$user);
    }

    public function getMemberApplicationsData(Request $request) {

        if ($request->wantsJson()) {

            $user = Auth::user();
    
            $applications = Application::with('product','user')->where('user_id',$user->id)->orderBy('created_at','DESC');
            
            if($applications) {

                return Datatables::of($applications)
                ->editColumn('title', function ($applications) {
                    return $applications->product->title;
                })
                ->editColumn('price', function ($applications) {
                    return '&#8369;'. number_format($applications->product->price); 
                })
                ->addColumn('brand', function ($applications) {
                    return $applications->product->product_brand;
                })
                ->editColumn('brand_type', function ($applications) {
                    return $applications->product->brand_type;
                })
                ->editColumn('down_payment', function ($applications) {
                    return $applications->product->down_payment;
                })
                ->addColumn('status', function ($applications) {
                    if($applications->status == 'PENDING') {
                        return '<span class="text-warning">PENDING</span>';
                    } elseif($applications->status == 'APPROVED') {
                        return '<span class="text-success">APPROVED</span>';
                    } elseif($applications->status == 'DECLINED') {
                        return '<span class="text-danger">DECLINED</span>';
                    }
                })
                ->addColumn('date', function ($applications) {
                    return date('F j, Y g:i a', strtotime($applications->created_at)) . ' | ' . $applications->created_at->diffForHumans();
                })
                ->addIndexColumn()
                ->rawColumns(['title','price','brand','brand_type','down_payment','status','date'])
                ->make(true);

            }else{

                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again.'),422);
            }

        } else{

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

}
