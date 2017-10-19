<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class LoginController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {

        if ($this->guard()->attempt(['name' => 'admin', 'password' => 'admin'])) {
            echo '登录陈工';
        } else {
            echo '登录失败';
        }

        return redirect('admin');
    }

    protected function guard($name = 'admin')
    {
        return Auth::guard($name);
    }
}
