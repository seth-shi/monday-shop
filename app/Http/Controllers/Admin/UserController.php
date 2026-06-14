<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()->when($request->filled('q'), fn ($query) => $query->where(fn ($inner) => $inner->where('name', 'like', '%'.$request->string('q').'%')->orWhere('email', 'like', '%'.$request->string('q').'%')))->latest('id')->paginate(20)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function toggle(User $user)
    {
        $user->is_active = ! $user->is_active;
        $user->save();
        return back()->with('status', $user->is_active ? '用户已启用' : '用户已停用');
    }
}
