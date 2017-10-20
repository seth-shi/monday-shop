<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Requests\StoreAdminPost;
use App\Repositories\AdminRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class LoginController extends Controller
{
    protected $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(StoreAdminPost $request)
    {
        list($account, $password) = array_values($request->only(['account', 'password']));

        if ($admin = $this->adminRepository->getUserByNameAndPassword($account, $password)) {

            session(['admin' => $admin->name]);
            return redirect('admin');
        } else {

            return back()->withInput()->withErrors(['account' => '账号或者密码错误']);
        }

    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin');

        return back();
    }

}
