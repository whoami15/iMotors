<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use App\Models\User;
use App\Models\Application;
use App\Models\Payment;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\MotorType;
use App\Models\Products;
use App\Models\Photos;
use App\Http\Requests\Admin\AddProductRequest;
use App\Http\Requests\Admin\EditProductRequest;
use Session;
use Redirect;
use Cache;
use Hash;
use DB;
use PDF;
use URL;
use DateTime;
use Carbon\Carbon;

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
        $applications_count = Application::count();
        $approved_applications_count = Application::where('status','APPROVED')->count();
        $products_count = Products::where('is_active',1)->count();
        $summary = getAdminDashboardCounts();
        
        return view('admin.dashboard')
            ->with('user',$user)
            ->with('summary',$summary)
            ->with('applications',$applications)
            ->with('applications_count',$applications_count)
            ->with('approved_applications_count',$approved_applications_count)
            ->with('products_count',$products_count);
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
        
        return  view('admin.applications.list')->with('user',$user);      
    }

    public function getAdminApplicationsData(Request $request) {

        if ($request->wantsJson()) {

            $user = Auth::user();

            if($request->has('sort_by')) {

                $sort = $request->sort_by;

                if($sort == 'RECENT'){
                    $applications = Application::with('user','product')->orderBy('created_at','desc');
                } else {
                    $applications = Application::with('user','product')->where('status',$sort)->orderBy('created_at','desc');
                }
            } else {

                $applications = Application::with('user','product')->orderBy('created_at','desc');
            }

            if($applications){

                return Datatables::of($applications)
                ->editColumn('name', function ($applications) {
                    return ucwords($applications->user->full_name);
                })
                ->editColumn('mobile', function ($applications) {
                    return $applications->user->mobile;
                })
                ->editColumn('product', function ($applications) {
                    return $applications->product->title;
                })
                ->editColumn('down_payment', function ($applications) {
                    return '<strong>&#8369;'.number_format($applications->down_payment).'</strong>';
                })
                ->addColumn('action', function ($applications) {
                    return '<a class="btn btn-success btn-sm" href="/admin/application/view/'.$applications->id.'">View</a>';  
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
                ->rawColumns(['name','mobile','product','down_payment','action','status','date'])
                ->make(true);

            }else{

                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
            }

        }else{

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }

    }

    public function getAdminViewApplication($id) {

        $application = Application::with('product','user')->where('id',$id)->first();

        if(!$application) {

            Session::flash('danger', 'Application not found.');
            return Redirect::back();
        }

        $monthly_payment = ($application->product->price - $application->down_payment) / $application->payment_length;

        return view('admin.applications.view')
            ->with('application',$application)
            ->with('monthly_payment',$monthly_payment);
    }

    public function postAdminUpdateApplication($id, Request $request) {

        $application = Application::with('product','user')->where('id',$id)->first();

        if(!$application) {

            Session::flash('danger', 'Application not found.');
            return Redirect::back();
        }

        $application->status = $request->status;
        $application->reason = $request->reason;
        $application->save();

        if($request->status == "APPROVED") {
            $product = Products::find($application->product_id);
            $product->decrement('stock');
            $product->save();
        }

        Session::flash('success', 'Application has been updated.');
        return Redirect::back();
    }

    // Products

    public function getAdminAddProduct() {

        $user = Auth::user();

        $brands = Brand::get();
        $motor_types = MotorType::get();
        $branches = Branch::get();

        return view('admin.products.add')
            ->with('brands',$brands)
            ->with('motor_types',$motor_types)
            ->with('branches',$branches);
    }

    public function postAdminAddProduct(AddProductRequest $request) {

        try {

            $user = Auth::user();

            $product = new Products;
            $product->user_id = $user->id;
            $product->product_brand = $request->product_brand;
            $product->brand_type = $request->brand_type;
            $product->branch = $request->branch;
            $product->title = $request->title;
            $product->stock = $request->stock;
            $product->description = $request->description;
            $product->down_payment = $request->down_payment;
            $product->price = $request->price;
            $product->payment_length = $request->payment_length;
            $product->is_featured = ($request->is_featured) == NULL ? 0 : $request->is_featured;
            $product->is_active = 1;

            $product->save();

            if($request->file('photos')) {

                foreach($request->file('photos') as $photo){
                    $photos = new Photos;

                    $photoName = strtotime("now").'-'.str_replace(' ', '', $photo->getClientOriginalName());
                    $photo->move(public_path('media'.'/'.$product->id), $photoName);
                    $photos->product_id = $product->id;
                    $photos->filename = URL::asset('/media').'/'.$product->id.'/'.$photoName;
                    $photos->save();
                }
            }

            Session::flash('success', 'Product Successfully added.');
            return Redirect::back();

        } catch(\Exception $e) {

            Session::flash('danger', $e->getMessage());
            return Redirect::back();
        }
    }

    public function getAdminProducts() {

        $user = Auth::user();

        return view('admin.products.list')->with('user',$user);
    }

    public function getAdminProductData(Request $request) {

        if ($request->wantsJson()) {

            $products = Products::orderBy('created_at','desc');
            
            if($products){

                return Datatables::of($products)
                ->editColumn('title', function ($products) {
                    return $products->title;
                })
                ->editColumn('price', function ($products) {
                    return '&#8369;'. number_format($products->price) .'<br/>(Down Payment: &#8369;'.number_format($products->down_payment).')'; 
                })
                ->editColumn('stock', function ($products) {
                    return $products->stock;
                })
                ->addColumn('brand', function ($products) {
                    return $products->product_brand;
                })
                ->editColumn('brand_type', function ($products) {
                    return $products->brand_type;
                })
                ->editColumn('branch', function ($products) {
                    return $products->branch;
                })
                ->addColumn('action', function ($products) {
                    return '<a class="btn btn-danger btn-sm" href="/admin/products/edit/'.$products->id.'">Edit</a>';  
                })
                ->addColumn('date', function ($products) {
                    return date('F j, Y g:i a', strtotime($products->created_at)) . ' | ' . $products->created_at->diffForHumans();
                })
                ->addIndexColumn()
                ->rawColumns(['title','price','brand','brand_type','stock','branch','action','date'])
                ->make(true);

            }else{

                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again.'),422);
            }

        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }

    }

    public function getAdminEditProduct($id) {

        $user = Auth::user();

        $product = Products::with('photos')->where('id',$id)->first();
        $brands = Brand::get();
        $motor_types = MotorType::get();
        $branches = Branch::get();

        if($product) {

            return view('admin.products.edit')
                ->with('user',$user)
                ->with('product',$product)
                ->with('brands',$brands)
                ->with('motor_types',$motor_types)
                ->with('branches',$branches);
        } else {
            
            return redirect('/admin/products');
        }

    }

    public function postAdminEditProduct($id, EditProductRequest $request) {

        try {

            $user = Auth::user();

            $product = Products::where('user_id',$user->id)->find($id);

            $product->product_brand = $request->product_brand;
            $product->brand_type = $request->brand_type;
            $product->branch = $request->branch;
            $product->title = $request->title;
            $product->stock = $request->stock;
            $product->description = $request->description;
            $product->down_payment = $request->down_payment;
            $product->price = $request->price;
            $product->payment_length = $request->payment_length;
            $product->is_featured = ($request->is_featured) == NULL ? 0 : $request->is_featured;
            $product->is_active = $request->is_active;

            $product->save();

            if($request->file('photos')) {

                foreach($request->file('photos') as $photo){

                    $photos = Photos::where('product_id', $id)->first();
                    $photoName = strtotime("now").'-'.str_replace(' ', '', $photo->getClientOriginalName());
                    $photo->move(public_path('media'.'/'.$product->id), $photoName);
                    $photos->product_id = $product->id;
                    $photos->filename = URL::asset('/media').'/'.$product->id.'/'.$photoName;
                    $photos->save();

                }
            }

            Session::flash('success', 'Product Successfully updated.');
            return Redirect::back();

        } catch(\Exception $e) {

            Session::flash('danger', $e->getMessage());
            return Redirect::back();
        }
    }

    public function postAdminAddBrand(Request $request) {

        try {

            $brand = new Brand;
            $brand->brand_name = $request->brand_name;
            $brand->description = $request->description;
            $brand->status = 1;

            if($request->file('photo')) {

                $photo = $request->file('photo');

                $photoName = strtotime("now").'-'.str_replace(' ', '', $photo->getClientOriginalName());
                $photo->move(public_path('brand/'), $photoName);
                $brand->filename = URL::asset('/brand').'/'.$photoName;
                
            }

            $brand->save();


            Session::flash('success', 'Brand Successfully added.');
            return Redirect::back();

        } catch(\Exception $e) {

            Session::flash('danger', $e->getMessage());
            return Redirect::back();
        }
    }

    public function postAdminAddMotorType(Request $request) {

        try {

            $motor_type = new MotorType;
            $motor_type->type = $request->type;
            $motor_type->description = $request->description;
            $motor_type->status = 1;

            $motor_type->save();

            Session::flash('success', 'Motor Type Successfully added.');
            return Redirect::back();

        } catch(\Exception $e) {

            Session::flash('danger', $e->getMessage());
            return Redirect::back();
        }
    }

    public function postAdminAddBranch(Request $request) {

        try {

            $branch = new Branch;
            $branch->branch_name = $request->branch_name;
            $branch->description = $request->description;
            $branch->status = 1;

            $branch->save();

            Session::flash('success', 'Branch Successfully added.');
            return Redirect::back();

        } catch(\Exception $e) {

            Session::flash('danger', $e->getMessage());
            return Redirect::back();
        }
    }

    public function getAdminPaymentsList() {

        $user = Auth::user();
        
        return view('admin.payment.list')->with('user',$user);
    }

    public function getAdminPaymentsListData(Request $request) {

        if ($request->wantsJson()) {

            $user = Auth::user();
    
            $payments = Payment::with('application','user')->orderBy('created_at','DESC');
            
            if($payments) {

                return Datatables::of($payments)
                ->editColumn('customer', function ($payments) {
                    return $payments->application->user->first_name .' '. $payments->application->user->last_name;
                })
                ->editColumn('code', function ($payments) {
                    return $payments->application->code;
                })
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
                ->rawColumns(['customer','product','code','amount','payment_date','date','action'])
                ->make(true);

            }else{

                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again.'),422);
            }

        } else{

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function getAdminPayLoan() {

        $user = Auth::user();
        
        return view('admin.payment.pay')->with('user',$user);
    }

    public function postAdminPayLoan(Request $request) {
        
        $loan = Application::with('product','user','payment')->where('code',$request->loan_code)->where('status','APPROVED')->first();

        if(!$loan) {

            Session::flash('danger', 'Loan not found or Pending.');
            return Redirect::back();
        }

        $user = User::where('username',$request->username)->orWhere('email',$request->username)->first();

        if(!$user) {

            Session::flash('danger', 'User not found.');
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
        return redirect('/admin/loan/pay');
    }

    public function getAdminDueList() {

        $user = Auth::user();
        
        return view('admin.payment.due')->with('user',$user);
    }

    public function getAdminDueListData(Request $request) {

        if ($request->wantsJson()) {

            $user = Auth::user();
    
            $loans = Application::with('product','user','payment')->where('last_payment_date', '<=', Carbon::now()->subMonth())->where('status','APPROVED')->orderBy('created_at','DESC');

            if($loans) {

                return Datatables::of($loans)
                ->editColumn('customer', function ($loans) {
                    return $loans->user->first_name .' '. $loans->user->last_name;
                })
                ->editColumn('code', function ($loans) {
                    return $loans->code;
                })
                ->editColumn('product', function ($loans) {
                    return $loans->product->title;
                })
                ->editColumn('mobile', function ($loans) {
                    return '<strong>'. $loans->user->mobile. '</strong>'; 
                })
                ->addColumn('last_payment_date', function ($loans) {
                    return date('F j, Y g:i a', strtotime($loans->last_payment_date)). ' | ' . $loans->last_payment_date->diffForHumans();
                })
                ->addIndexColumn()
                ->rawColumns(['customer','code','product','mobile','last_payment_date'])
                ->make(true);

            }else{

                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again.'),422);
            }

        } else{

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

}
