<?php

namespace App\Http\Middleware;

use Closure;

class UserTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$objectToAccess)
    {
        $usertype = $request->user()->userType->type;
        if($objectToAccess == 'users' || $objectToAccess == 'usertype' 
                || $objectToAccess == 'homeownermember' || $objectToAccess == 'settings'){
            if($usertype === 'Administrator')
                return $next($request);
        }elseif($objectToAccess == 'reports' || $objectToAccess == 'journal' 
                || $objectToAccess == 'asset' || $objectToAccess == 'accounttitle'
                || $objectToAccess == 'accountinformation' || $objectToAccess == 'vendor'
                || $objectToAccess == 'items') {
            if($usertype === 'Administrator' || $usertype === 'Accountant')
                return $next($request);
        }elseif($objectToAccess == 'receipts' || $objectToAccess == 'expense'
                || $objectToAccess == 'homeownerinfo') {
            if($usertype === 'Administrator' || $usertype === 'Accountant' || $usertype === 'Cashier')
                return $next($request);
        }elseif($objectToAccess == 'announcement' || $objectToAccess == 'map'){
            if($usertype === 'Administrator' || $usertype === 'Guest')
                return $next($request);
        }elseif($objectToAccess == 'invoice'){
            if($usertype === 'Administrator' || $usertype === 'Accountant' || $usertype === 'Cashier'|| $usertype === 'Guest')
                return $next($request);
        }

        return view('errors.404');
        
    }
}
