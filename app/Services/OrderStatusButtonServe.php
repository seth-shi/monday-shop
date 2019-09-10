<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderStatusButtonServe
{
    private $order;
    private $buttons = [];

    public function __construct(Order $order)
    {
        $this->order = $order;
    }


    public function cancelOrderButton()
    {
        $url = url("/user/orders/{$this->order->id}/cancel");

        $this->buttons[] = <<<BUTTON
<a href="{$url}" 
   class="am-btn am-btn-default anniu">取消订单</a>
BUTTON;

        return $this;
    }

    public function deleteButton()
    {
        $this->buttons[] = <<<BUTTON
<a href="javascript:;" data-id="{$this->order->id}"
   class="am-btn am-btn-default anniu delete_btn">删除订单</a>
BUTTON;

        return $this;
    }

    public function payButton()
    {
        $this->buttons[] = <<<BUTTON
<a href="/user/pay/orders/{$this->order->id}/again"
   class="am-btn am-btn-danger anniu">去付款</a>
BUTTON;

        return $this;
    }

    public function refundButton()
    {
        $this->buttons[] = <<<BUTTON
<a href="javascript:;" data-id="{$this->order->id}"
   class="am-btn am-btn-default anniu refund_btn">退款</a>
BUTTON;

        return $this;
    }
    public function shipButton()
    {
        $this->buttons[] = <<<BUTTON
<a href="javascript:;" data-id="{$this->order->id}"
   class="am-btn am-btn-success anniu confirm_btn">确认收货</a>
BUTTON;

        return $this;
    }

    public function completeButton()
    {
        $this->buttons[] = <<<BUTTON
 <a href="javascript:;"
    data-id="{$this->order->id}"
    class="am-btn am-btn-success anniu comment_btn"
data-score="{$this->order->score}">评价</a>
BUTTON;
    }

    public function replyBuyButton()
    {
        if (! $this->order->relationLoaded('details')) {
            $this->order->load('details', 'details.product');
        }

        $parameters = $this->order->details->map(function (OrderDetail $orderDetail) {

            $uuid  = $orderDetail->product->uuid ?? '';
            return "ids[]={$uuid}&numbers[]={$orderDetail->number}";
        })->implode('&');

        $url = '/user/comment/orders/create?' . $parameters;

        $this->buttons[] = <<<BUTTON
<a href="{$url}"
   class="am-btn am-btn-success anniu">再来一单</a>
BUTTON;

        return $this;
    }

    public function getButtons()
    {
        return $this->buttons;
    }
}
