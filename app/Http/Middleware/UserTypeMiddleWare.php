<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserTypeMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userType = Auth::user()->userType->type; 
        if($userType=='Accountant'){
            return redirect('/account'); 
        }else if($userType=='Cashier'){
            return redirect('/invoice'); 
        }
        return $next($request);
    }
}
