<?php

namespace App\Http\Controllers\Auth;

use DB;
use Mail;
use App\User;
use Validator;
use App\InvoiceModel;
use App\SettingsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255|min:5',
            'middle_name' => 'required|max:255|min:5',
            'last_name' => 'required|max:255|min:2',
            'email' => 'required|email|max:255|unique:users',
            'g-recaptcha-response' => 'required|captcha'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'confirmation_code' => $data['confirmation_code'],
            'user_type_id' => $data['user_type_id'],
        ]);
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {   
        $user = User::first();
        if (view()->exists('auth.authenticate')) {
            return view('auth.authenticate',
                            compact('user'));
        }

        return view('auth.login'); 
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * Override Functions
     */
    public function postLogin(Request $request)
    {
        
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        //Store temporary username and password
        $credentials = array('email'=>'','password'=>'');
        $userCred = array('email'=>$request->input('email'),'is_active'=>1);
        //Check if logged-in user is active
        $userCredential = DB::table('users')
                            ->where($userCred)
                            ->first();

        if(!empty($userCredential)){
            $credentials = $this->getCredentials($request);
        }

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $name  = (Auth::user()->first_name==null?
                        (Auth::user()->homeOwner->first_name . ' ' . Auth::user()->homeOwner->last_name):
                        (Auth::user()->first_name . ' ' . Auth::user()->last_name));

            //Check if user is a homeowner
            if(Auth::user()->userType->type=='Guest'){
                //Check if there are invoices that exceeded payment due date
                $ehomeOwnerInvoicesList = InvoiceModel::where('is_paid' ,'=', 0)
                                                        ->where('home_owner_id','=',Auth::user()->home_owner_id)
                                                        ->where('payment_due_date','<',date('Y-m-d'))
                                                        ->get();
                if(!empty($ehomeOwnerInvoicesList)){
                    flash()->overlay('Welcome Back <strong>' . $name  . '</strong>' . '<br/>' . 'You have ' . count($ehomeOwnerInvoicesList) . ' invoice/s that exceeded payment due date.','Welcome');
                }else{
                    flash()->overlay('Welcome Back <strong>' . $name  . '</strong>','Welcome');
                }  
            }else{
              flash()->overlay('Welcome Back <strong>' . $name  . '</strong>','Welcome');  
            }
            
            $this->createSystemLogs('User '. $name .' has logged in');
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([$this->loginUsername() => $this->getFailedLoginMessage(),]);    
        
        
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $throttles
     * @return \Illuminate\Http\Response
     * Override Functions
     */
    protected function handleUserWasAuthenticated(Request $request, $throttles)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::user());
        }

        //Added redirect path if user is
        return $this->userTypeRedirectPath();
        
    }

    /**
    * @Date:         7/3/2016
    * @Description:  Redirect path for login user based in Usertype 
    * @return        string
    */
    public function userTypeRedirectPath(){
        $userType = Auth::user()->userType->type;
        if($userType=='Administrator'){
            $setting = SettingsModel::first();
            if($setting == NULL)
                return redirect()->intended('/settings/create'); 
            else
                return redirect()->intended('/admin-dashboard'); 
        }else if($userType=='Accountant'){
            return redirect()->intended('/account'); 
        }else if($userType=='Cashier'){
            return redirect()->intended('/invoice'); 
        }else if($userType=='Guest'){
            return redirect()->intended('/guest-dashboard');
        }
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * Override Functions
     */
    public function postRegister(Request $request)
    {
        try{
            $confirmation_code = trim(str_random(30));
            $guestUserType = DB::table('user_type')
                            ->where(array('type'=>'Guest'))
                            ->first();

            $adminUser = DB::table('users')
                            ->where(array('user_type_id'=>1))
                            ->first();
            $data = $request->all();
            $data['confirmation_code'] = $confirmation_code;
            $data['user_type_id'] = count($adminUser)>0?$guestUserType->id:1;

            $validator = $this->validator($data);

            if ($validator->fails()) {
                return redirect('auth/login#signup')
                        ->withInput($request->input())
                        ->withErrors($validator, $this->errorBag());

            }

            $this->create($data);

            //Send email verification
            $this->sendEmailVerification($data['email'],
                                            $data['first_name'] . ' ' . $data['middle_name'] . ' ' . $data['last_name'],
                                            array('confirmation_code'=>$confirmation_code));
            Auth::logout();
            flash()->success('An email is sent to your account for verification.');
            return redirect('auth/login');    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
    }

    public function sendEmailVerification($toAddress,$name,$confirmation_code){
        Mail::send('emails.user_verifier',$confirmation_code, function($message) use ($toAddress, $name){
            $message->from('SomersetAccountingSystem@noreply.com','User Verification');
            $message->to($toAddress, $name)
                        ->subject('Verify your Account');
        });
    }

    public function createSystemLogs($action){
        DB::table('system_logs')->insert(array('created_by'=>Auth::user()->id,
                                                'updated_by'=>Auth::user()->id,
                                                'action'=>$action,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s')));
    }
}
