<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use DB;
use Session;
use Redirect;
use Carbon\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function getLogin()
    {   
        if (Auth::check()) {
            
            $role = Auth::user()->role;

            if ($role == 1) {
                return redirect('/dashboard');
            } elseif ($role == 2) {
                return redirect('/admin');   
            } elseif ($role == 3) {
                return redirect('/subadmin');   
            } else {
                return view('auth.login');
            }

        } else {
            return view('auth.login');
        }
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $message = Lang::get('auth.throttle', ['seconds' => $seconds]);

        return response()->json(array("result"=>false,"msg"=> $message),423);

    }

    public function postLogin(LoginRequest $request)
    {

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
          $this->fireLockoutEvent($request);

          return $this->sendLockoutResponse($request);
        }
        
        $userdata = array(
            'email'  => $request->email,
            'password'  => $request->password
        );
        
        //return $userdata;
        // attempt to do the login
        if (Auth::attempt($userdata)) {

                $user = Auth::user();

                // if($user->banned == true || $user->banned == 1){

                //     Auth::logout();
                //     Session::flush();
                //     Session::flash('banned', "Account has been banned!");

                //     return redirect('/login');

                // } else {

                    $this->clearLoginAttempts($request);

                    if ($user->role == 1) {
                        $user->last_login_at = Carbon::now();
                        $user->save();

                        return redirect('/dashboard');
                        
                    } elseif ($user->role == 2) {
                        return redirect('/admin');
                    } elseif ($user->role == 3) {
                        return redirect('/subadmin');   
                    } 

                //}
                
        } else {      

            $this->incrementLoginAttempts($request);

            Session::flash('danger', "Login failed wrong user credentials!");
        
            return Redirect::back();
            
        }
        
    }

    public function logout() {
        if (Auth::user()){
            Auth::logout();
            Session::flush();
            return redirect('/login');
        } else {
            return redirect('/login');  
        }
    }
}
