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
use App\Models\ScoreRule;
use App\Models\User;
use App\Services\ScoreLogServe;
use Auth;
use DB;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class OrderController extends Controller
{

    public function index()
    {
        // 获取积分比例
        $scoreRatio = $this->getScoreRatio();

        /**
         * @var $user User
         */
        $user = auth()->user();
        $orders = $user->orders()
                       ->latest()
                       ->with('details', 'details.product')
                       ->get()
                       ->transform(function (Order $order) use ($scoreRatio) {

                           // 可以或得到的积分
                           $order->score = ceil($order->total * $scoreRatio);
                           return $order;
                       });



        return view('user.orders.index', compact('orders'));
    }



    public function show(Order $order)
    {
        if ($order->user_id != Auth::user()->id) {
            abort(403, '你没有权限');
        }

        return view('user.orders.show', compact('order'));
    }


    public function completeOrder(Order $order)
    {
        // 判断是当前用户的订单才可以删除
        if (auth()->id() != $order->user_id) {

            abort(403, '不是自己的订单');
        }

        // 只有付完款的订单,而且必须是未完成的
        if ($order->status == Order::STATUSES['ALI']) {

            (new ScoreLogServe)->completeOrderAddSCore($order);
        }
        $order->status = Order::STATUSES['COMPLETE'];
        $order->save();

        return back()->with('status', '完成订单已增加积分');
    }

    /**
     * 获取积分和钱的换比例
     * @return mixed
     */
    protected function getScoreRatio()
    {
        $scoreRule = ScoreRule::query()->where('index_code', ScoreRule::INDEX_COMPLETE_ORDER)->firstOrFail();

        return $scoreRule->score ?? 1;
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

        // 如果订单已经完成不能删除
        if ($order->status == Order::STATUSES['COMPLETE']) {

            abort(403, '完成的订单不可删除');
        }

        $order->delete();

        return back()->with('status', '删除成功');
    }

}
