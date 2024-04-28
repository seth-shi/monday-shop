<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (\Exception $exception, Request $request) {
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
        });
    }
}
