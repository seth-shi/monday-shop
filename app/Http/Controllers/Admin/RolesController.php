<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * 角色的列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $roles = Role::query()->where('guard_name', 'admin')->get();

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * 角色的创建页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $permissions = Permission::query()->where('guard_name', 'admin')->get();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * 角色创建逻辑
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleRequest $request)
    {
        $roleData = $request->only('name');
        $roleData['guard_name'] = 'admin';
        $role = Role::create($roleData);

        // 把获取到的权限全部分配给角色
        array_map(function($item) use ($role){
            $role->givePermissionTo($item['name']);
        }, $request->input('permission'));

        return back()->with('status', '创建角色成功');
    }

    public function show(Role $role)
    {
        return $role;
    }

    /**
     * 编辑角色页面
     *
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role)
    {
        $permissions = Permission::query()->where('guard_name', 'admin')->get();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * 修改角色逻辑
     *
     * @param RoleRequest $request
     * @param Role        $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->only('name'));
        // 同步参数中的权限
        $role->syncPermissions($request->input('permission'));

        return back()->with('status', '修改角色成功');
    }

    /**
     * 删除角色
     *
     * @param Role $role
     * @return array
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        if ($role->delete()) {
            return ['msg' => '删除成功', 'code' => 200];
        } else {
            return ['msg' => '删除失败', 'code' => 401];
        }
    }
}
