<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminsController extends Controller
{
    /**
     * 管理员列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $admins = Admin::query()->latest()->get();


        return view('admin.admins.index', compact('admins'));
    }


    /**
     * 创建管理员页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        // 创建管理员需要分配权限，所以查询出来
        $roles = Role::query()->where('guard_name', 'admin')->get();

        return view('admin.admins.create', compact('roles'));
    }

    /**
     * 创建管理员逻辑处理
     *
     * @param AdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminRequest $request)
    {
        list($adminData, $roles) = $this->getFormParam($request);

        /**
         * @var $admin Admin
         */
        $admin = Admin::query()->create($adminData);
        $admin->assignRole($roles);

        return redirect('/admin/admins')->with('status', '创建成功');
    }

    /**
     * 管理员编辑页面
     *
     * @param Admin $admin
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Admin $admin)
    {

        $roles = Role::query()->where('guard_name', 'admin')->get();

        return view('admin.admins.edit', compact('admin', 'roles'));
    }


    /**
     * 管理员修改逻辑
     *
     * @param AdminRequest $request
     * @param Admin        $admin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        list($adminData, $roles) = $this->getFormParam($request);

        $admin->update($adminData);
        // 同步管理员的权限
        $admin->syncRoles($roles);

        return redirect('/admin/admins')->with('status', '修改成功');
    }


    public function show(Admin $admin)
    {
        return $admin;
    }


    /**
     * 删除管理员
     *
     * @param Admin $admin
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return back()->with('status', '删除成功');
    }


    /**
     * 格式化管理员的资料
     * 得到所有角色
     *
     * @param Request $request
     * @return array
     */
    private function getFormParam(Request $request)
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
