<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ShareCarSum
{
    /**
     * The view factory implementation.
     *
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $view;

    /**
     * Create a new error binder instance.
     *
     * @param  \Illuminate\Contracts\View\Factory  $view
     * @return void
     */
    public function __construct(ViewFactory $view)
    {
        $this->view = $view;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 如果用户已经登录，那么就是他的数量，如果用户没有登录，那么就是 0
        $sum = 0;
        /**
         * @var $user User
         */
        if ($user = auth()->user()) {

            $sum = $user->cars()->sum('number');
        }


        $this->view->share(
            'carSum', $sum
        );


        return $next($request);
    }
}
