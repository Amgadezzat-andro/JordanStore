<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

       
        $user = Auth::user();
        
        // if user not verified the email then returns to login
        if (!$user->email_verified) {
            return redirect(route('home'));
        }
        
        return $next($request);
    }
}
