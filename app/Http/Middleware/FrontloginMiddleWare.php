<?php

namespace App\Http\Middleware;

use Closure;

class FrontloginMiddleWare
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
        if(empty($request->session()->has('frontendSession')))
        {
            return redirect()->route('login-register');
        }
        return $next($request);
    }
}
