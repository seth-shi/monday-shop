<?php

namespace App\Http\Middleware;

use Closure;

class LoginAfterRedirectPath
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
        dd($request);
        if ($request->has('redirect_url')) {

            $request->session()->put('url.intended', $request->input('redirect_url'));
        }


        return $next($request);
    }
}
