<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PermissionRequest;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{

    public function index()
    {
        $permissions = Permission::where('guard_name', 'admin')->get();

        return view('admin.permissions.index', compact('permissions'));
    }


    public function create()
    {
        return view('admin.permissions.create');
    }


    public function store(PermissionRequest $request)
    {
        $permissionData = $request->only('name');
        $permissionData['guard_name'] = 'admin';

        Permission::create($permissionData);

        return back()->with('status', '创建权限成功');
    }


    public function show(Permission $permission)
    {
        return $permission;
    }


    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }


    public function update(PermissionRequest $request, Permission $permission)
    {
        $permission->update($request->only('name'));

        return back()->with('status', '修改权限成功');
    }


    public function destroy(Permission $permission)
    {
        if ($permission->delete()) {
            return ['msg' => '删除成功', 'code' => 200];
        } else {
            return ['msg' => '删除失败', 'code' => 401];
        }
    }
}
