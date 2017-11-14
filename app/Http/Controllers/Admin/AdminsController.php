<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminsController extends Controller
{
    public function index()
    {
        $admins = Admin::latest()->get();

        return view('admin.admins.index', compact('admins'));
    }


    public function create()
    {
        $roles = Role::where('guard_name', 'admin')->get();

        return view('admin.admins.create', compact('roles'));
    }

    public function store(AdminRequest $request)
    {
        $this->checkPermission('添加管理员');

        list($adminData, $roles) = $this->getFormParam($request);

        $admin = Admin::create($adminData);
        $admin->assignRole($roles);

        return redirect('/admin/admins')->with('status', '创建成功');
    }


    public function edit(Admin $admin)
    {
        $roles = Role::where('guard_name', 'admin')->get();

        return view('admin.admins.edit', compact('admin', 'roles'));
    }


    public function update(AdminRequest $request, Admin $admin)
    {
        $this->checkPermission('修改管理员');

        list($adminData, $roles) = $this->getFormParam($request);

        $admin->update($adminData);
        $admin->syncRoles($roles);

        return redirect('/admin/admins')->with('status', '修改成功');
    }

    public function show(Admin $admin)
    {
        return $admin;
    }


    public function destroy(Admin $admin)
    {
        $this->checkPermission('删除管理员');

        $admin->delete();
        return back()->with('status', '删除成功');
    }




    private function getFormParam($request)
    {
        $admin['name'] = $request->input('name');

        // exists and not null
        if ($request->input('password')) {

            $admin['password'] = Hash::make($request->input('password'));
        }

        $roles = array_column($request->input('roles'), 'role');

        return [$admin, $roles];
    }

    private function checkPermission($permission)
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
