<?php

namespace App\Http\Middleware;

use Closure;

class PreventLogin
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
        if($request->session()->has('auser') || $request->session()->has('fuser') || $request->session()->has('user')){
            return response()->redirectTo('/');
        }
        else{
            return $next($request);
        }
    }
}
 