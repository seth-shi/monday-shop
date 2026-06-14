<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (AuthenticationException $exception, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return responseJsonAsUnAuthorized('登录状态已失效，请重新登录');
            }
        });

        $this->renderable(function (ValidationException $exception, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return responseJsonAsBadRequest($exception->validator->errors()->first());
            }
        });

        $this->reportable(function (Throwable $exception): void {
            // Laravel's default reporters handle the exception.
        });
    }
}
