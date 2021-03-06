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
use App\Models\PayPal;
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
        $applications = Application::with('product')->where('user_id',$user->id)->orderBy('created_at','DESC')->take(5)->get();
        $loans = Application::with('product')->where('user_id',$user->id)->where('status','APPROVED')->orderBy('created_at','DESC')->take(5)->get();
        $summary = getDashboardCounts($user->id);
        $due = getTotalDue($user->id);
        
        return view('member.dashboard')
            ->with('user',$user)
            ->with('summary',$summary)
            ->with('due',$due)
            ->with('applications',$applications)
            ->with('loans',$loans);      
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

        // code
        $alphabet = '1qw2e?rtyu(io3pasd4f*ghj5]klzx6c)vbnmP7?OIUYT8R@EWQLK9JHGFD#SAMN[BVCXZ0';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
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

        $code = Application::where('code', implode($pass))->first();
        if(!$code){
            $application->code = implode($pass);
            $code = substr(md5(uniqid(mt_rand(), true)) , 0, 10);
            $code = strToUpper($code);
        }

        $application->save();

        // sa third step ito
        $payment = new Payment;
        $payment->user_id = $user->id;
        $payment->application_id = $application->id;
        $payment->amount = $request->down_payment;
        $payment->status = 'PENDING';
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
                ->editColumn('code', function ($applications) {
                    return $applications->code;
                })
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
                        return '<span class="badge bg-warning">PENDING</span>';
                    } elseif($applications->status == 'APPROVED') {
                        return '<span class="badge bg-success">APPROVED</span>';
                    } elseif($applications->status == 'DECLINED') {
                        return '<span class="badge bg-danger">DECLINED</span>';
                    }
                })
                ->addColumn('date', function ($applications) {
                    return date('F j, Y g:i a', strtotime($applications->created_at)) . ' | ' . $applications->created_at->diffForHumans();
                })
                ->addColumn('action', function ($applications) {
                    return '<a class="btn btn-primary btn-sm" href="/application/view/'.$applications->id.'">View</a>';  
                })
                ->addIndexColumn()
                ->rawColumns(['code','title','price','brand','brand_type','down_payment','status','date','action'])
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

        $diff_in_days = $past->diffInDays($dt);

        $plus_due = 0;

        $plus_due_amount = 0;

        if($diff_in_days > 30) {

            $plus_due = $diff_in_days - 30;

            if($plus_due >= 3) {

                $plus_due = 3;
                
                $plus_due_amount = $monthly_payment * 0.05;
            }
        }

        

        //if($months_to_pay == 0) {

        //    Session::flash('danger', 'Nothing to Pay.');
        //    return Redirect::back();
        //}
        
        return view('member.payment.pay')
            ->with('user',$user)
            ->with('loan',$loan)
            ->with('months_to_pay',$months_to_pay)
            ->with('plus_due',$plus_due)
            ->with('plus_due_amount',$plus_due_amount)
            ->with('monthly_payment',$monthly_payment)
            ->with('balance',$balance);
    }

    public function postMemberPayLoan($id, Request $request) {
        
        $user = Auth::user();

        $loan = Application::with('product','user','payment')->where('id',$id)->where('user_id',$user->id)->where('status','APPROVED')->first();

        if(!$loan) {

            Session::flash('danger', 'Loan not found.');
            return Redirect::back();
        }

        //dd(number_format((float) $request->amount, 2));
        if($request->payment_method == "REMITTANCE") {

            $amount = str_replace(",", "", $request->amount);
            $payment = new Payment;
            $payment->user_id = $user->id;
            $payment->application_id = $loan->id;
            $payment->amount = (float)$amount;
            $payment->payment_date = Carbon::now();
        
            $payment->payment_method = "REMITTANCE";
            $payment->details = 'REFERENCE NO.: '.$request->reference_number. '<br>NAME: '.$request->sender_name.'<br>MOBILE: '.$request->sender_mobile;
            
            $payment->status = 'PENDING';
            $payment->save();
            
            $loan->last_payment_date = Carbon::now();
            $loan->save();

        } elseif($request->payment_method == "PAYPAL") {

            //save muna tapos sa completed kunin yung latest order by id desc 

            $amount = str_replace(",", "", $request->amount);
            
            $payment = new Payment;
            $payment->user_id = $user->id;
            $payment->application_id = $loan->id;
            $payment->amount = $amount;
            $payment->payment_date = Carbon::now();
            $payment->payment_method = "PAYPAL";
            $payment->status = 'PENDING';
            $payment->save();
 
            $loan->last_payment_date = Carbon::now();
            $loan->save();

            $paypal = new PayPal;

            $amount = str_replace(",", "", $request->amount);

            $response = $paypal->purchase([
                'amount' => $paypal->formatAmount((float)$amount),
                'transactionId' => time().$user->id.'-'.$loan->id,
                'currency' => 'PHP',
                'cancelUrl' => $paypal->getCancelUrl($loan),
                'returnUrl' => $paypal->getReturnUrl($loan),
            ]);
    
            if ($response->isRedirect()) {
                $response->redirect();
            }

            Session::flash('danger', $response->getMessage());
            return Redirect::back();

        }

        Session::flash('success','Payment has been Successfully Submitted for Review to Our Administrator.');
        return redirect('/payments');
    }

    public function completed($id, Request $request) {

        $user = Auth::user();

        $loan = Application::findOrFail($id);

        $latest_payment = Payment::where('user_id',$user->id)->where('application_id',$loan->id)->orderBy('id','DESC')->first();

        $paypal = new PayPal;

        $response = $paypal->complete([
            'amount' => $paypal->formatAmount($latest_payment->amount),
            'transactionId' => time().$user->id.'-'.$loan->id,
            'currency' => 'PHP',
            'cancelUrl' => $paypal->getCancelUrl($loan),
            'returnUrl' => $paypal->getReturnUrl($loan),
            'notifyUrl' => $paypal->getNotifyUrl($loan),
        ]);

        if ($response->isSuccessful()) {

            $latest_payment->transaction_id = $response->getTransactionReference();
            $latest_payment->payment_status = 1;
            $latest_payment->payment_method = "PAYPAL";
            $latest_payment->save();

            Session::flash('success', 'Payment has been Successfully Submitted for Review to Our Administrator. Reference Code: ' . $response->getTransactionReference());
            return redirect('/loan/pay/'.$id);
        }

        Session::flash('danger', $response->getMessage());
        return Redirect::back();

    }

    public function cancelled($id) {

        $user = Auth::user();

        $loan = Application::findOrFail($id);

        $latest_payment = Payment::where('user_id',$user->id)->where('application_id',$loan->id)->orderBy('id','DESC')->first();
        $latest_payment->delete();

        Session::flash('danger', 'You have canceled your recent PayPal payment.');
        return redirect('/loan/pay/'.$id);

    }

    public function webhook($order_id, $env, Request $request) {
        // to do with new release of sudiptpa/paypal-ipn v3.0 (under development)
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
                ->editColumn('loan', function ($applications) {
                    return $applications->loan;
                })
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
                        return '<span class="badge bg-danger">'. $past->diffInMonths($dt). ' MONTH(s)</span>';
                    } else {
                        return 'NONE';
                    }
                })
                ->addColumn('status', function ($applications) {
                    if($applications->status == 'PENDING') {
                        return '<span class="badge bg-warning">PENDING</span>';
                    } elseif($applications->status == 'APPROVED') {
                        return '<span class="badge bg-success">APPROVED</span>';
                    } elseif($applications->status == 'DECLINED') {
                        return '<span class="badge bg-danger">DECLINED</span>';
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
                            return '<a class="btn btn-danger btn-block" href="/loan/pay/'.$applications->id.'"><strong>DUE | PAY <i class="fa fa-arrow-right"></i></strong></a>';
                        } else {
                            return '<a class="btn btn-success btn-block" href="/loan/pay/'.$applications->id.'"><strong>PAY <i class="fa fa-arrow-right"></i></strong></a>';
                        }
                    } else {
                        return 'NONE';
                    }
                })
                ->addIndexColumn()
                ->rawColumns(['loan','title','price','down_payment','months_unpaid','status','date','action'])
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
    
            $payments = Payment::with('application','user')->where('user_id',$user->id)->where('status','APPROVED')->orderBy('created_at','DESC');
            
            if($payments) {

                return Datatables::of($payments)
                ->editColumn('code', function ($payments) {
                    return $payments->application->code;
                })
                ->editColumn('payment_method', function ($payments) {
                    return $payments->payment_method;
                })
                ->editColumn('details', function ($payments) {
                    if($payments->payment_method == "REMITTANCE") {

                        return nl2br($payments->details);
                    } elseif($payments->payment_method == "PAYPAL") {

                        return 'Transaction Code: '.$payments->transaction_id;
                    } elseif($payments->payment_method == "ADMIN") {

                        return 'Payment From Admin';
                    }
                })
                //->editColumn('details', '{!! nl2br($details) !!}')
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
                ->addColumn('status', function ($payments) {
                    if($payments->status == 'PENDING') {
                        return '<span class="badge bg-warning">PENDING</span>';
                    } elseif($payments->status == 'APPROVED') {
                        return '<span class="badge bg-success">APPROVED</span>';
                    } elseif($payments->status == 'DECLINED') {
                        return '<span class="badge bg-danger">DECLINED</span>';
                    }
                })
                ->addColumn('action', function ($payments) {
                    return '<a class="btn btn-danger btn-block" href="/payment/invoice/'.$payments->id.'"><strong>Invoice</strong></a>';
                })
                ->addIndexColumn()
                ->rawColumns(['code','payment_method','details','product','amount','payment_date','date','status','action'])
                ->make(true);

            }else{

                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again.'),422);
            }

        } else{

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function getMemberPaymentInvoice(Request $request, $id) {

        $user = Auth::user();
    
        $payment = Payment::with('application','user')->where('user_id',$user->id)->where('id',$id)->first();

        if(!$payment) {
            Session::flash('danger', 'Payment not found.');
            return redirect('/payments');
        } 
        return view('member.payment.print')->with('payment',$payment);
    }

}
