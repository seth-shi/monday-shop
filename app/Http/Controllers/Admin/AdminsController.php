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
        //
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
        if ( $this->guard()->user()->can('edit admin')) {

            return back()->with('status', '权限不足');
        }

        $roles = Role::where('guard_name', 'admin')->get();
        $admin->role = $admin->getRoleNames()->first();

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
        if ( $this->guard()->user()->can('edit admin')) {

            return back()->with('status', '权限不足');
        }

        $admin->name = $request->input('name');
        $admin->password = Hash::make($request->input('password'));
        $admin->save();

        $admin->syncRoles($request->input('role'));

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
        // $this->guard()->user()->givePermissionTo('delete admin');
        if (! $this->guard()->user()->can('delete admin')) {

            return back()->with('status', '权限不足');
        }

        $admin->delete();
        return back()->with('status', '删除成功');
    }

    public function guard()
    {
        return Auth::guard('admin');
    }
}
