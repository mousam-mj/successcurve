<?php

namespace App\Http\Middleware;
use Illuminate\Auth\Middleware\CheckStudentLogin as Middleware;
use Closure;
use Session;

class CheckStudentLogin extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function redirectTo($request)
    {
        if(!Session::get('user'))
            return redirect('login');
    }
}
