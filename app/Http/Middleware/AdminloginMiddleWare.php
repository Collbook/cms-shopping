<?php

namespace App\Http\Middleware;

use Closure;
use Brian2694\Toastr\Facades\Toastr;

class AdminloginMiddleWare
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
        //echo $request->session()->get('frontendSession', 'default'); die();
        if(empty($request->session()->has('adminSession')))
        {
            Toastr::error('Authentication faild','Errors');
            return redirect()->route('admin.login');
        }
        return $next($request);
    }
}
