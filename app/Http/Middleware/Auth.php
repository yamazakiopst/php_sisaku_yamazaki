<?php

namespace App\Http\Middleware;

use Closure;

class Auth
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
        //ログインが必要なページへのアクセス制御
        if (!session()->has('login_user')) {
            return redirect()->route('menu.user');
        }
        return $next($request);
    }
}
