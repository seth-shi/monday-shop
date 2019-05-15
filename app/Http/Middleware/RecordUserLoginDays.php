<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\ScoreLogServe;
use Closure;

class RecordUserLoginDays
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
        /**
         * @var $user User
         * 如果用户已经登录, 则看是否可以增加积分
         */
        $user = auth()->user();

        if (! is_null($user)) {

            (new ScoreLogServe)->loginAddScore($user);
        }

        return $next($request);
    }
}
