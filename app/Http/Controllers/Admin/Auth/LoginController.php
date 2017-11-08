<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Requests\StoreAdminPost;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(StoreAdminPost $request)
    {
        $fields = $request->only(['name', 'password']);

        if ($this->guard()->attempt($fields, true)) {

            $this->authenticated($request);
            return redirect('admin');
        }

        return back()->withInput()->withErrors(['name' => '账号或者密码错误']);
    }


    public function authenticated($request)
    {
        $admin = $this->guard()->user();

        $request->setTrustedProxies(['192.168.0.1']);
        $admin->last_ip = $request->getClientIp();
        $admin->save();
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        return redirect()->route('admin.login');
    }

    public function guard($name = 'admin')
    {
        return Auth::guard($name);
    }

}
