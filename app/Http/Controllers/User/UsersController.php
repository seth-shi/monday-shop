<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{

    public function index()
    {
        $user = $this->guard()->user();
        $hotProduct = Product::where('safe_count', 'desc')->first();


        return view('user.homes.index', compact('user', 'hotProduct'));
    }



    public function setting()
    {
        $user = Auth::user();

        return view('user.users.setting', compact('user'));
    }


    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
