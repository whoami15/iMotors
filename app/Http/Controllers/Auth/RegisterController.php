<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\RegisterRequest;
use DB;
use Session;
use Redirect;
use App\Models\User;
use App\Models\Branch;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getRegister()
    {
        if (Auth::check()) {
            
            $role = Auth::user()->role;

            if ($role == 1) {
                return redirect('/dashboard');   
            } elseif ($role == 2) {
                return redirect('/admin');   
            } elseif ($role == 3) {
                return redirect('/subadmin');   
            }  else {
                return view('auth.register');
            }

        } else {

            $nearest_branch = Branch::where('status',1)->get();
            return view('auth.register')->with('nearest_branch', $nearest_branch);
        }
    }

    public function postRegister(RegisterRequest $request){

        if (Auth::check()) {

            $role = Auth::user()->role;

            if ($role == 1) {
                return redirect('/dashboard');   
            } elseif ($role == 2) {
                return redirect('/admin');
            } elseif ($role == 3) {
                return redirect('/subadmin');   
            } else {
                return view('auth.register');
            }
        }

        try {

            $user = new User;
            $user->first_name = ucwords(strtolower($request->first_name));
            $user->middle_name = ucwords(strtolower($request->middle_name));
            $user->last_name = ucwords(strtolower($request->last_name));
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->mobile = $request->mobile;
            $user->birth_date = $request->birth_date;
            $user->gender = $request->gender;
            $user->barangay = $request->barangay;
            $user->municipal = $request->municipal;
            $user->province = $request->province;
            $user->nearest_branch = $request->nearest_branch;
            $user->role = 1;
            $user->save();
            
            Session::flash('success', "You have registered successfully.");
            return redirect('/login');

        } catch(\Exception $e) {
            
            Session::flash('danger', "Something went wrong.");
            return Redirect::back();
        }
        
    }
}
