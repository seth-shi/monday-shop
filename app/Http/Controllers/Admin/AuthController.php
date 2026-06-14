<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function create()
    {
        return Auth::guard('admin')->check() ? redirect()->route('admin.dashboard') : view('admin.auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate(['username' => ['required', 'string'], 'password' => ['required', 'string']]);

        if (! Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['username' => '用户名或密码错误'])->onlyInput('username');
        }

        $request->session()->regenerate();
        $admin = Auth::guard('admin')->user();
        $admin->forceFill(['login_ip' => $request->ip()])->save();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
