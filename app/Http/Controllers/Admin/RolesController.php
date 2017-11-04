<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    public function index()
    {
        $roles = Role::where('guard_name', 'admin')->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

    public function show(Role $role)
    {
        return $role;
    }


    public function edit(Role $role)
    {
        $permissions = Permission::where('guard_name', 'admin')->get();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }


    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->only('name'));

        $role->syncPermissions($request->input('permission'));

        return back()->with('status', '修改角色成功');
    }


    public function destroy(Role $role)
    {
        //
    }
}
