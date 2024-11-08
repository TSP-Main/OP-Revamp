<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if ($user) {
            if($user->status == 1 || $user->status == 2 ){
                return $next($request);
            }
            else{
                session()->flush();
                Auth::logout();
        
                if (isset($user->role) && $user->role == user_roles('1')) {
                    return redirect('/login');
                } else if (isset($user->role) && $user->role == user_roles('2')) {
                    return redirect('/login');
                } else if (isset($user->role) && $user->role == user_roles('3')) {
                    return redirect('/login');
                } else if (isset($user->role) && $user->role == user_roles('4')) {
                    return redirect('/');
                }
            }
        }else{
            return redirect('/login');
        }
    }
}
