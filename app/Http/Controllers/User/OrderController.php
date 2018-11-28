<?php

namespace App\Http\Controllers\User;

use App\Events\CountSale;
use App\Exceptions\OrderException;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderMuiltRequest;
use App\Http\Requests\OrderRequest;
use App\Models\Address;
use App\Models\Car;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class OrderController extends Controller
{

    public function index()
    {
        /**
         * @var $user User
         */
        $user = auth()->user();
        $orders = $user->orders()->latest()->with('details', 'details.product')->get();

        return view('user.orders.index', compact('orders'));
    }



    public function show(Order $order)
    {
        if ($order->user_id != Auth::user()->id) {
            abort(403, '你没有权限');
        }

        return view('user.orders.show', compact('order'));
    }


    /**
     * 地址是否存在
     *
     * @param $address
     * @return bool
     */
    protected function hasAddress($address)
    {
        return Address::query()
                      ->where('user_id', auth()->id())
                      ->where('id', $address)
                      ->exists();
    }


    public function destroy($id)
    {
        $order = Order::query()->findOrFail($id);
        // 判断是当前用户的订单才可以删除
        if (auth()->id() != $order->user_id) {
            abort(403);
        }

        $order->delete();

        return back()->with('status', '删除成功');
    }

}
