<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use App\Models\User;
use App\Models\Application;
use App\Models\Products;
use App\Models\Payment;
use Session;
use Redirect;
use Cache;
use Hash;
use DB;
use PDF;
use URL;
use DateTime;
use Carbon\Carbon;

class MemberController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth');
        $this->middleware('member');
    }

    public function getMemberDashboard() {

        $user = Auth::user();
        $applications = Application::with('product')->orderBy('created_at','DESC')->take(5)->get();
        $summary = getDashboardCounts($user->id);
        $due = getTotalDue($user->id);
        
        return view('member.dashboard')
            ->with('user',$user)
            ->with('summary',$summary)
            ->with('due',$due)
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
        $application->last_payment_date = Carbon::now();
        $application->save();

        // sa third step ito
        $payment = new Payment;
        $payment->user_id = $user->id;
        $payment->application_id = $application->id;
        $payment->amount = $request->down_payment;
        $payment->payment_date = Carbon::now();
        $payment->save();

        Session::flash('success','Your application has been submitted. Click <a href="'. url('/application/view/' .$application->id) .'"><strong>HER</strong>E</a> to view.');
        return Redirect::back();
    }

    public function getMemberViewApplication($id) {

        $user = Auth::user();

        $application = Application::with('product','user')->where('id',$id)->where('user_id',$user->id)->first();

        if(!$application) {

            Session::flash('danger', 'Application not found.');
            return Redirect::back();
        }

        //$monthly_payment = ($application->product->price - $application->down_payment) / $application->payment_length;
        $monthly_payment = getMonthlyPayment($user->id,$application->id);

        return view('member.application.view')
            ->with('application',$application)
            ->with('monthly_payment',$monthly_payment);
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
                    return '&#8369;'. number_format($applications->down_payment);
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

    public function getMemberPayLoan($id) {

        $user = Auth::user();

        $loan = Application::with('product','user','payment')->where('id',$id)->where('user_id',$user->id)->where('status','APPROVED')->first();

        if(!$loan) {

            Session::flash('danger', 'Loan not found.');
            return Redirect::back();
        }

        $monthly_payment = getMonthlyPayment($user->id,$loan->id);

        $balance = getTotalBalance($user->id,$loan->id);

        $dt = Carbon::now();
//dd($loan->payment[0]->payment_date);

        $past = Carbon::parse($loan->last_payment_date);

        $final = $past->format('Y-m-d');

        $months_to_pay = $past->diffInMonths($dt);

        if($months_to_pay == 0) {

            Session::flash('danger', 'Nothing to Pay.');
            return Redirect::back();
        }
        
        return view('member.payment.pay')
            ->with('user',$user)
            ->with('loan',$loan)
            ->with('months_to_pay',$months_to_pay)
            ->with('monthly_payment',$monthly_payment)
            ->with('balance',$balance);
    }

    public function postMemberPayLoan($id, Request $request) {
        
        $user = Auth::user();

        $loan = Application::with('product','user','payment')->where('user_id',$user->id)->where('status','APPROVED')->first();

        if(!$loan) {

            Session::flash('danger', 'Loan not found.');
            return Redirect::back();
        }
        //dd(number_format((float) $request->amount, 2));
        $amount = str_replace(",", "", $request->amount);
        $payment = new Payment;
        $payment->user_id = $user->id;
        $payment->application_id = $loan->id;
        $payment->amount = (float)$amount;
        $payment->payment_date = Carbon::now();
        $payment->save();

        $loan->last_payment_date = Carbon::now();
        $loan->save();

        Session::flash('success','Payment Successful.');
        return redirect('/payments');
    }

    public function getMemberLoans() {

        $user = Auth::user();
        
        return view('member.payment.loans')->with('user',$user);
    }
    
    public function getMemberApplicationsToPayData(Request $request) {

        if ($request->wantsJson()) {

            $user = Auth::user();
    
            $applications = Application::with('product','payment','user')->where('user_id',$user->id)->where('status','APPROVED')->orderBy('created_at','DESC');

            if($applications) {

                return Datatables::of($applications)
                ->editColumn('title', function ($applications) {
                    return $applications->product->title;
                })
                ->editColumn('price', function ($applications) {
                    return '<strong>&#8369;'. number_format($applications->product->price) .'</strong>'; 
                })
                ->editColumn('down_payment', function ($applications) {
                    return '<strong>&#8369;'. number_format($applications->down_payment) .'</strong>';
                })
                ->editColumn('months_unpaid', function ($applications) {
                    $dt = Carbon::now();
                    if($applications->payment) {
                        $past = Carbon::parse($applications->last_payment_date);
                        $final = $past->format('Y-m-d');
                        return $past->diffInMonths($dt). ' MONTH(s)';
                    } else {
                        return 'NONE';
                    }
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

                    $dt = Carbon::now();

                    if($applications->payment) {

                        $past = Carbon::parse($applications->last_payment_date);
                        $final = $past->format('Y-m-d');
                        $count_unpaid = $past->diffInMonths($dt);

                        if($count_unpaid > 0) {
                            return '<a class="btn btn-danger btn-block" href="/loan/pay/'.$applications->id.'"><strong>PAY <i class="fa fa-arrow-right"></i></strong></a>';
                        } else {
                            return '<span class="text-bold">Nothing to Pay</label>';
                        }
                    } else {
                        return 'NONE';
                    }
                })
                ->addIndexColumn()
                ->rawColumns(['title','price','down_payment','months_unpaid','status','date','action'])
                ->make(true);

            }else{

                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again.'),422);
            }

        } else{

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
    }

    public function getMemberPaymentsList() {

        $user = Auth::user();
        
        return view('member.payment.list')->with('user',$user);
    }

    public function getMemberPaymentsListData(Request $request) {

        if ($request->wantsJson()) {

            $user = Auth::user();
    
            $payments = Payment::with('application','user')->where('user_id',$user->id)->orderBy('created_at','DESC');
            
            if($payments) {

                return Datatables::of($payments)
                ->editColumn('product', function ($payments) {
                    return $payments->application->product->title;
                })
                ->editColumn('amount', function ($payments) {
                    return '<strong>&#8369;'. number_format($payments->amount).'</strong>'; 
                })
                ->addColumn('payment_date', function ($payments) {
                    return date('F j, Y g:i a', strtotime($payments->payment_date)) . ' | ' . $payments->payment_date->diffForHumans();
                })
                ->addColumn('date', function ($payments) {
                    return date('F j, Y g:i a', strtotime($payments->created_at)) . ' | ' . $payments->created_at->diffForHumans();
                })
                ->addColumn('action', function ($payments) {
                    //return '<a class="btn btn-primary btn-sm" href="/application/view/'.$payments->id.'">View</a>';
                    return '';
                })
                ->addIndexColumn()
                ->rawColumns(['product','amount','payment_date','date','action'])
                ->make(true);

            }else{

                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again.'),422);
            }

        } else{

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

}
