<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class verifyUserByEmail
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
        $user = \App\User::find(Auth::id());
        if($user->status==0)
        {
            Auth::logout();
            return redirect('login')->with('error_message','Need to verify your account first, check your email.');
        }
        return $next($request);
    }
}
