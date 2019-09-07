<?php

namespace App\Http\Controllers\User;

use App\Admin\Transforms\OrderShipStatusTransform;
use App\Admin\Transforms\OrderStatusTransform;
use App\Enums\OrderShipStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\ScoreRuleIndexEnum;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\ScoreRule;
use App\Models\User;
use App\Services\ScoreLogServe;
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

                           $paid = $order->status == OrderStatusEnum::PAID;

                           // 可以或得到的积分
                           $order->score = ceil($order->amount * $scoreRatio);

                           // 完成按钮必须是已经支付和确认收货
                           $order->status_text = OrderStatusTransform::trans($order->status);

                           // 如果订单是付款了则显示发货状态
                           if ($paid) {


                               // 如果发货了,则显示发货信息
                               $order->status_text = OrderShipStatusTransform::trans($order->ship_status);
                           }

                           $order->show_completed_button = false;
                           $order->show_refund_button = false;
                           $order->show_pay_button = false;
                           $order->show_delete_button = false;
                           $order->show_ship_button = false;
                           if ($paid) {

                               // 已经确认收获了
                               if ($order->ship_status == OrderShipStatusEnum::RECEIVED) {
                                   $order->show_completed_button = true;
                               } elseif ($order->ship_status == OrderShipStatusEnum::DELIVERED) {

                                   $order->show_ship_button = true;
                               } else {
                                   $order->show_refund_button = true;
                               }

                           } elseif ($order->status == OrderStatusEnum::UN_PAY) {
                               $order->show_pay_button = true;
                           }

                           if ($order->status == OrderStatusEnum::COMPLETED) {
                               $order->show_delete_button = true;
                           }


                           return $order;
                       });



        return view('user.orders.index', compact('orders'));
    }



    public function show(Order $order)
    {
        if ($order->isNotUser(auth()->id())) {
            abort(403, '你没有权限');
        }

        $order->ship_send = $order->ship_status == OrderShipStatusEnum::DELIVERED;
        $order->confirm_ship = $order->ship_status == OrderShipStatusEnum::RECEIVED;

        if ($order->confirm_ship)  {

            $order->ship_send = true;
        }

        $order->completed = $order->status == OrderShipStatusEnum::RECEIVED;

        return view('user.orders.show', compact('order'));
    }


    public function completeOrder(Order $order)
    {
        // 判断是当前用户的订单才可以删除
        if ($order->isNotUser(auth()->id())) {
            abort(403, '你没有权限');
        }

        // 只有付完款的订单,而且必须是未完成的, 确认收货
        if (
            ! $order->status == OrderStatusEnum::PAID ||
            $order->ship_status != OrderShipStatusEnum::RECEIVED
        ) {
            return back()->withErrors(['msg' => '订单当前状态不能完成']);
        }

        (new ScoreLogServe)->completeOrderAddScore($order);

        $order->status = OrderStatusEnum::COMPLETED;
        $order->save();

        return back()->with('status', '完成订单已增加积分');
    }


    public function confirmShip(Order $order)
    {
        // 判断是当前用户的订单才可以删除
        if ($order->isNotUser(auth()->id())) {
            abort(403, '你没有权限');
        }

        if ($order->status != OrderStatusEnum::PAID) {

            return back()->withErrors('订单未付款');
        }

        if ($order->ship_status != OrderShipStatusEnum::DELIVERED) {

            return back()->withErrors('订单未发货');
        }

        $order->ship_status = OrderShipStatusEnum::RECEIVED;
        $order->save();

        return back()->with('status', '收货成功');
    }

    /**
     * 获取积分和钱的换比例
     * @return mixed
     */
    protected function getScoreRatio()
    {
        $scoreRule = ScoreRule::query()->where('index_code', ScoreRuleIndexEnum::COMPLETE_ORDER)->firstOrFail();

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
        /**
         * @var $order Order
         */
        $order = Order::query()->findOrFail($id);
        // 判断是当前用户的订单才可以删除
        if ($order->isNotUser(auth()->id())) {
            abort(403, '你没有权限');
        }

        // 支付的订单不能删除
        if ($order->status != OrderStatusEnum::COMPLETED) {

            abort(403, '未完成的订单不能删除');
        }

        $order->delete();

        return back()->with('status', '删除成功');
    }

}
