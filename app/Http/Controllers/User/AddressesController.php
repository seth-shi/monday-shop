<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\AddressRequest;
use App\Models\Address;
use Auth;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressesController extends Controller
{

    protected $response = [
        'code' => 1,
        'msg' => '服务器异常，请稍后再试',
    ];

    public function index()
    {
        $addresses = $this->guard()->user()->addresses;

        // Provincial and municipal regions
        $provinces = DB::table('provinces')->get();
        $cities = DB::table('cities')->where('province_id', $provinces->first()->id)->get();

        return view('user.addresses.index', compact('addresses', 'provinces', 'cities'));
    }


    public function store(AddressRequest $request)
    {
        $addressesData = $this->getFormatRequest($request);

        $this->guard()->user()->addresses()->create($addressesData);

        return back()->with('status', '创建成功');
    }


    public function show(Address $address)
    {
        return $address;
    }


    public function edit(Address $address)
    {
        $addresses = $this->guard()->user()->addresses;

        return view('user.addresses.edit', compact('addresses', 'address'));
    }


    public function update(AddressRequest $request, Address $address)
    {
        $this->checkPermission($address->user_id);

        $addressesData = $this->getFormatRequest($request);

        $address->update($addressesData);

        return back()->with('status', '修改成功');
    }

    public function destroy(Address $address)
    {
        if ($this->owns($address->user_id)) {
            return $this->response;
        }

        if ($address->delete()) {
            $this->response = ['code' => 0, 'msg' => '删除成功'];
        }

        return $this->response;
    }

    public function setDefaultAddress(Address $address)
    {
        if (! $this->owns($address->user_id)) {
            return $this->response;
        }

        Address::where('user_id', $address->user_id)->update(['is_default' => 0]);
        $address->is_default = 1;

        if ($address->save()) {
            $this->response = [
                'code' => 0,
                'msg' => '设置成功',
            ];
        }

        return $this->response;
    }

    protected function checkPermission($userID)
    {
        if (! $this->owns($userID)) {
            abort(404, '你没有权限');
        }
    }

    protected function owns($userID)
    {
        return $this->guard()->user()->id == $userID;
    }

    protected function guard()
    {
        return Auth::guard();
    }

    protected function getFormatRequest($request)
    {
        return $request->only(['name', 'phone', 'province', 'city','detail_address',]);
    }


    public function getCities(Request $request)
    {
        return DB::table('cities')->where('province_id', $request->input('province_id'))->get();
    }
}
