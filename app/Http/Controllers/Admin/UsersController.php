<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * 用户列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::query()->orderBy('login_count', 'desc')->paginate(5);

        return view('admin.users.index', compact('users'));
    }

}
