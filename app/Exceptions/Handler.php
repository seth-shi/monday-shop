<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->is('api*')) {

            if ($exception instanceof JWTException) {

                $mapExceptions = [
                    TokenInvalidException::class => '无效的token',
                    TokenBlacklistedException::class => 'token 已被加入黑名单,请重新登录'
                ];

                $msg = $mapExceptions[get_class($exception)] ?? $exception->getMessage();
                return responseJsonAsUnAuthorized($msg);
            }
            // 拦截表单验证错误抛出的异常
            elseif ($exception instanceof ValidationException) {

                return responseJsonAsBadRequest($exception->validator->errors()->first());
            }


            return responseJsonAsServerError($exception->getMessage());
        }


        return parent::render($request, $exception);
    }
}
