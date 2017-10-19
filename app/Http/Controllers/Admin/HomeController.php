<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    public function index()
    {
        // dd(Role::create(['name' => 'warehouse']), Permission::create(['name' => 'edit_product']));

        // $user = User::where('name', 'waitmoonman')->first();

        // 分配角色
        // dd($user->assignRole('admin'));

        // 分配权限
        // dd($user->givePermissionTo('edit_product'));


        // dd($user->hasRole('warehouse'));

        dd(Auth::guard('admin')->user());
    }
}
