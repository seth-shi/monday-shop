<?php

namespace App\Http\Middleware;

use Auth;
use Closure;


class UserAuth
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
        if (! Auth::check()) {

            $url = route('login') . '?redirect_url=' . url()->current();

            return redirect($url)->with('status', '请登录账号再操作');
        }

        return $next($request);
    }
}
