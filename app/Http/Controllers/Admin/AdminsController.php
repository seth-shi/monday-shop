<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::orderBy('created_at', 'desc')->get();

        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $this->checkPermission('edit admin');

        $roles = Role::where('guard_name', 'admin')->get();

        return view('admin.admins.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        $this->checkPermission('edit admin');

        list($adminData, $roles) = $this->getUpdateFormRequest($request);

        $admin->update($adminData);
        $admin->syncRoles($roles);

        return redirect('/admin/admins')->with('status', '修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $this->checkPermission('delete admin');

        $admin->delete();
        return back()->with('status', '删除成功');
    }




    private function getUpdateFormRequest($request)
    {
        $admin['name'] = $request->input('name');

        // exists and not null
        if ($request->input('password')) {

            $admin['password'] = Hash::make($request->input('password'));
        }

        $roles = array_values($request->input('roles'));

        return [$admin, $roles];
    }

    private function checkPermission($permission)
    {
        if (! $this->guard()->user()->can($permission)) {

            return back()->with('status', '权限不足');
        }
    }

    public function guard()
    {
        return Auth::guard('admin');
    }
}
