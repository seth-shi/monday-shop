<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    public function index()
    {
        return view('admin.roles.index');
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
        //
        dd($role);
    }


    public function edit(Role $role)
    {
        //
    }


    public function update(Request $request, Role $role)
    {
        //
    }


    public function destroy(Role $role)
    {
        //
    }
}
