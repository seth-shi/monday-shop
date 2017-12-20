<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\PermissionTrait;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
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
}
