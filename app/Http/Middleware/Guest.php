<?php

namespace App\Http\Middleware;

use Closure;

class Guest
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
        //未ログインでのみ参照可能なページへのアクセス制御
        if (session()->has('login_user')) {
            return redirect()->route('menu.user');
        }
        return $next($request);
    }
}
