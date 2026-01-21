<?php

namespace App\Http\Middleware;

use Closure;

class CustomFacAuth
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
       if($request->session()->has('fuser')){
            return $next($request);
        }
        else{
            return response()->redirectTo('login');
        }
    }
}
 