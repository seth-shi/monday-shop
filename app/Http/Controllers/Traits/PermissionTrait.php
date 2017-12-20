<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Auth;

trait PermissionTrait
{
    public function checkPermission($permission)
    {
        if (! $this->guard()->user()->can($permission)) {

            abort(404, '权限不足');
        }
    }

    public function guard()
    {
        return Auth::guard('admin');
    }
}