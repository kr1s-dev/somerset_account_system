<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class RedirectIfAuthenticated
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if ($this->auth->check()) {
            $userType = $request->user()->userType->type;
            if($userType=='Administrator' || $userType=='Tester'){
                return redirect()->intended('/admin-dashboard'); 
            }else if($userType=='Accountant'){
                return redirect()->intended('/account'); 
            }else if($userType=='Cashier'){
                return redirect()->intended('/invoice'); 
            }else if($userType=='Guest'){
                return redirect()->intended('/guest-dashboard');
            }
        }
        
        
        return $next($request);
    }
}
