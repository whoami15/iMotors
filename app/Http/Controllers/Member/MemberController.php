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

            $check_product = Products::active()->where('id',$request->product)->first();
            
            if($check_product) {

                $products = Products::active()->get();

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

    public function postMemberApplication(Request $request) {
        
        $user = Auth::user();

        $product = Products::where('id',$request->product_id)->first();

        if(!$product) {

            Session::flash('danger', 'Product not found.');
            return Redirect::back();
        }

        $application = new Application;
        $application->user_id = $user->id;
        $application->product_id = $product->id;
        $application->purpose = $request->purpose;
        $application->unit_user = $request->unit_user;
        $application->down_payment = $request->down_payment;
        $application->payment_length = $request->payment_length;
        $application->present_address = $request->present_address;
        $application->previous_address = $request->previous_address;
        $application->provincial_address = $request->provincial_address;
        $application->civil_status = $request->civil_status;
        $application->mobile = $request->mobile;
        $application->sex = $request->sex;
        $application->tin = $request->tin;
        $application->birth_place = $request->birth_place;
        $application->birth_date = $request->birth_date;
        $application->age = $request->age;
        $application->educational_attainment = $request->educational_attainment;
        $application->course = $request->course;
        $application->school = $request->school;
        $application->year_graduated = $request->year_graduated;
        $application->status = 'PENDING';
        $application->save();

        Session::flash('success','Your application has been submitted. Click <a href="'. url('/application/view/' .$application->id) .'"><strong>HER</strong>E</a> to view.');
        return Redirect::back();
    }

    public function getMemberViewApplication($id) {

        $user = Auth::user();

        $application = Application::where('id',$id)->where('user_id',$user->id)->first();

        if(!$application) {

            Session::flush('danger', 'Application not found.');
            return Redirect::back();
        }

        return view('member.application.view')->with('application',$application);
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
                ->addColumn('action', function ($applications) {
                    return '<a class="btn btn-primary btn-sm" href="/application/view/'.$applications->id.'">View</a>';  
                })
                ->addIndexColumn()
                ->rawColumns(['title','price','brand','brand_type','down_payment','status','date','action'])
                ->make(true);

            }else{

                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again.'),422);
            }

        } else{

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

}
