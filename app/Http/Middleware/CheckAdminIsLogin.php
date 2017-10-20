<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminIsLogin
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
        if (! session()->has('admin')) {

            return redirect()->route('admin.login')->with('status', '请登录账号再操作');
        }

        return $next($request);
    }
}
