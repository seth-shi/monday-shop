<?php

namespace App\Http\Middleware;


use Closure;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class AuthRefreshToken extends BaseMiddleware
{
    /**
     * 检查用户登录，用户正常登录
     *
     * @param         $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws JWTException
     */
    public function handle($request, Closure $next)
    {
        /****************************************
         * 检查token 是否存在
         ****************************************/
        if (! $this->auth->parser()->hasToken()) {

            return responseJsonAsUnAuthorized('未在请求中找到 token 验证信息');
        }


        // 设置过期时间
        try {
            /****************************************
             * 尝试通过 tokne 登录，如果正常，就获取到用户
             * 无法正确的登录，抛出 token 异常
             ****************************************/
            if ($this->auth->parseToken()->authenticate()) {

                return $next($request);
            }

            return responseJsonAsNoFound('用户信息找不到');
        }
        // token 过期之后抛出的异常，尝试刷新 token
        catch (TokenExpiredException $e) {

            try {
                /****************************************
                 * token 过期的异常，尝试刷新 token
                 * 使用 id 一次性登录以保证此次请求的成功
                 ****************************************/
                $token = $this->auth->refresh();
                $id = $this->auth->getPayload()->get('sub');
                auth()->onceUsingId($id);

                // 在响应头中返回新的 token
                return $this->setAuthenticationHeader($next($request), $token);
            }
            // 已经无法刷新了，或者会被直接加入黑名单
            catch (JWTException $e) {

                /****************************************
                 * 如果捕获到此异常，即代表 refresh 也过期了，
                 * 用户无法刷新令牌，需要重新登录。
                 ****************************************/
                return responseJsonAsAccountExpired('登录已过期,请重新登录');
            }
        }

        // 更多的异常不会捕获, 直接再 Handler.php 处理
    }
}
