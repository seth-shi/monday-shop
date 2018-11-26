<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\AddressRequest;
use App\Models\Address;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressesController extends Controller
{

    public function index()
    {
        $addresses = auth()->user()->addresses;

        // Provincial and municipal regions
        $provinces = DB::table('provinces')->get();
        $cities = DB::table('cities')->where('province_id', $provinces->first()->id)->get();

        return view('user.addresses.index', compact('addresses', 'provinces', 'cities'));
    }


    public function store(AddressRequest $request)
    {
        $addressesData = $this->getFormatRequest($request);

        /**
         * @var $user User
         */
        $user = auth()->user();
        $user->addresses()->create($addressesData);

        return back()->with('status', '创建成功');
    }


    public function show(Address $address)
    {
        return $address;
    }


    public function edit(Address $address)
    {
        if (auth()->id() != $address->user_id) {

            abort(403, '非法操作');
        }

        $addresses = auth()->user()->addresses;
        // Provincial and municipal regions
        $provinces = DB::table('provinces')->get();
        $cities = DB::table('cities')->where('province_id', $address->province_id)->get();

        return view('user.addresses.edit', compact('addresses', 'address', 'provinces', 'cities'));
    }


    public function update(AddressRequest $request, Address $address)
    {
        if (auth()->id() != $address->user_id) {

            abort(403, '非法操作');
        }

        $addressesData = $this->getFormatRequest($request);

        $address->update($addressesData);

        return back()->with('status', '修改成功');
    }

    public function destroy(Address $address)
    {
        if (auth()->id() != $address->user_id) {

            return response()->json([
                'code' => 403,
                'msg' => '非法操作'
            ]);
        }

        $address->delete();

        return response()->json(['code' => 0, 'msg' => '删除成功']);
    }


    public function setDefaultAddress(Address $address)
    {
        if (auth()->id() != $address->user_id) {

            return response()->json([
                'code' => 403,
                'msg' => '非法操作'
            ]);
        }

        Address::query()->where('user_id', $address->user_id)->update(['is_default' => 0]);
        $address->is_default = 1;

        if ($address->save()) {
            $this->response = [
                'code' => 0,
                'msg' => '设置成功',
            ];
        }

        return $this->response;
    }


    protected function getFormatRequest(Request $request)
    {
        return $request->only(['name', 'phone', 'province_id', 'city_id','detail_address']);
    }


    public function getCities(Request $request)
    {
        return DB::table('cities')->where('province_id', $request->input('province_id'))->get();
    }
}
