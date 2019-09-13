<?php

namespace App\Http\Controllers\User;

use App\Admin\Transforms\OrderShipStatusTransform;
use App\Admin\Transforms\OrderStatusTransform;
use App\Enums\OrderShipStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\ScoreRuleIndexEnum;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Comment;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ScoreRule;
use App\Models\User;
use App\Services\OrderStatusButtonServe;
use App\Services\ScoreLogServe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yansongda\Pay\Pay;

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
        $query = $user->orders();

        switch (request('tab', 0)) {

            case 0:
                break;
            case 1:
                // 待付款
                $query->where('status', OrderStatusEnum::UN_PAY);
                break;
            case 2:
                // 未发货
                $query->where('status', OrderStatusEnum::PAID)->where('ship_status', OrderShipStatusEnum::PENDING);
                break;
            case 3:
                // 待收货
                $query->where('status', OrderStatusEnum::PAID)->where('ship_status', OrderShipStatusEnum::DELIVERED);
                break;
            case 4:
                // 待评价
                $query->where('status', OrderStatusEnum::PAID)->where('ship_status', OrderShipStatusEnum::RECEIVED);
                break;
        }

        $orders = $query->latest()
                        ->with('details', 'details.product')
                        ->get()
                        ->map(
                            function (Order $order) use ($scoreRatio) {

                                // 可以或得到的积分
                                $order->score = ceil($order->amount*$scoreRatio);

                                // 完成按钮必须是已经支付和确认收货
                                $order->status_text = OrderStatusTransform::trans($order->status);
                                // 如果订单是付款了则显示发货状态
                                if ($order->status == OrderStatusEnum::PAID) {

                                    // 如果发货了,则显示发货信息
                                    $order->status_text = OrderShipStatusTransform::trans($order->ship_status);
                                }

                                $buttonServe = new OrderStatusButtonServe($order);
                                switch ($order->status) {
                                    // 未支付的
                                    case OrderStatusEnum::UN_PAY:

                                        $buttonServe->payButton()->cancelOrderButton();
                                        break;
                                    case OrderStatusEnum::PAID:
                                        // 已经确认收获了
                                        if ($order->ship_status == OrderShipStatusEnum::RECEIVED) {

                                            $buttonServe->completeButton();
                                        } elseif ($order->ship_status == OrderShipStatusEnum::DELIVERED) {

                                            $buttonServe->shipButton();
                                        } else {

                                            $buttonServe->refundButton();
                                        }
                                        break;

                                    // 手动取消的订单
                                    // 已经完成的订单
                                    // 超时取消的订单
                                    case OrderStatusEnum::UN_PAY_CANCEL:
                                    case OrderStatusEnum::COMPLETED:
                                    case OrderStatusEnum::TIMEOUT_CANCEL:
                                        $buttonServe->replyBuyButton()->deleteButton();
                                        break;
                                }

                                $order->buttons = $buttonServe->getButtons();

                                return $order;
                            }
                        );


        // 查询订单总量
        $unPayCount = $user->orders()->where('status', OrderStatusEnum::UN_PAY)->count();
        $shipPendingCount = $user->orders()->where('status', OrderStatusEnum::PAID)->where('ship_status', OrderShipStatusEnum::PENDING)->count();
        $shipDeliveredCount = $user->orders()->where('status', OrderStatusEnum::PAID)->where('ship_status', OrderShipStatusEnum::DELIVERED)->count();
        $shipReceivedCount = $user->orders()->where('status', OrderStatusEnum::PAID)->where('ship_status', OrderShipStatusEnum::RECEIVED)->count();
        $ordersCount = $user->orders()->count();

        return view('user.orders.index', compact('orders', 'unPayCount', 'shipPendingCount', 'shipDeliveredCount', 'shipReceivedCount', 'ordersCount'));
    }




    public function show(Order $order)
    {
        if ($order->isNotUser(auth()->id())) {
            abort(403, '你没有权限');
        }

        $order->ship_send = $order->ship_status == OrderShipStatusEnum::DELIVERED;
        $order->confirm_ship = $order->ship_status == OrderShipStatusEnum::RECEIVED;

        if ($order->confirm_ship) {

            $order->ship_send = true;
        }

        $order->completed = $order->status == OrderShipStatusEnum::RECEIVED;

        return view('user.orders.show', compact('order'));
    }


    public function completeOrder(Order $order, Request $request)
    {
        $star = intval($request->input('star'));
        $content = $request->input('content');
        if ($star < 0 || $star > 5) {

            return responseJsonAsBadRequest('无效的评分');
        }

        if (empty($content)) {

            return responseJsonAsBadRequest('请至少些一些内容吧');
        }

        // 判断是当前用户的订单才可以删除
        $user = auth()->user();
        if ($order->isNotUser($user->id)) {

            return responseJsonAsBadRequest('你没有权限');
        }

        // 只有付完款的订单,而且必须是未完成的, 确认收货
        if (
            // 必须是已经付款，且已经确认收货的
            ! ($order->status == OrderStatusEnum::PAID && $order->ship_status == OrderShipStatusEnum::RECEIVED)
        ) {
            return responseJsonAsBadRequest('订单当前状态不能完成');
        }


        $orderDetails = $order->details()->get();
        $comments = $orderDetails->map(function (OrderDetail $orderDetail) use ($user, $content, $star) {

            return [
                'order_id' => $orderDetail->order_id,
                'order_detail_id' => $orderDetail->id,
                'product_id' => $orderDetail->product_id,
                'user_id' => $user->id,
                'score' => $star,
                'content' => $content,
            ];
        });

        DB::beginTransaction();

        try {

            // 订单完成
            $order->status = OrderStatusEnum::COMPLETED;
            $order->save();

            // 评论内容
            Comment::query()->insert($comments->all());

            OrderDetail::query()->where('order_id', $order->id)->update(['is_commented' => true]);

            // 完成订单增加积分
            (new ScoreLogServe)->completeOrderAddScore($order);

            DB::commit();
        } catch (\Exception $e) {

            return responseJsonAsServerError('服务器异常，请稍后再试');
        }


        return responseJson(200, '完成订单已增加积分');
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


    public function cancelOrder(Order $order)
    {
        // 判断是当前用户的订单才可以删除
        if ($order->isNotUser(auth()->id())) {
            abort(403, '你没有权限');
        }

        if ($order->status != OrderStatusEnum::UN_PAY) {

            return back()->withErrors('未付款的订单才能取消');
        }



        $pay = Pay::alipay(config('pay.ali'));

        try {
            $orderData = [
                'out_trade_no' => $order->no,
            ];
            $result = $pay->cancel($orderData);

            $order->status = OrderStatusEnum::UN_PAY_CANCEL;
            $order->save();

        } catch (\Exception $e) {

            return back()->withErrors('服务器异常，请稍后再试');
        }


        return back()->with('status', '取消成功');
    }

    /**
     * 获取积分和钱的换比例
     *
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
        if (! in_array($order->status, [OrderStatusEnum::UN_PAY_CANCEL, OrderStatusEnum::TIMEOUT_CANCEL, OrderStatusEnum::COMPLETED])) {

            abort(403, '订单不能删除');
        }

        $order->delete();

        return back()->with('status', '删除成功');
    }

}
