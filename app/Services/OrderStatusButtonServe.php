<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderStatusButtonServe
{
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function deleteButton()
    {
        return <<<BUTTON
<a href="javascript:;" data-id="{{ $this->order->id }}"
   class="am-btn am-btn-default anniu delete_btn">删除订单</a>
BUTTON;

    }

    public function payButton()
    {
        return <<<BUTTON
<a href="/user/pay/orders/{{ $this->order->id }}/again"
   class="am-btn am-btn-danger anniu">去付款</a>
BUTTON;

    }

    public function refundButton()
    {
        return <<<BUTTON
<a href="javascript:;" data-id="{{ $this->order->id }}"
   class="am-btn am-btn-default anniu refund_btn">退款</a>
BUTTON;

    }
    public function shipButton()
    {
        return <<<BUTTON
<a href="javascript:;" data-id="{{ $this->order->id }}"
   class="am-btn am-btn-success anniu confirm_btn">确认收货</a>
BUTTON;

    }

    public function completeButton()
    {
        return <<<BUTTON
 <a href="javascript:;"
    data-id="{{ $this->order->id }}"
    class="am-btn am-btn-success anniu comment_btn"
data-score="{{ $this->order->score }}">评价</a>
BUTTON;
    }

    public function replyBuyButton()
    {
        if (! $this->order->relationLoaded('details')) {
            $this->order->load('details');
        }

        $parameters = $this->order->details->map(function (OrderDetail $orderDetail) {
           return "ids[]={$orderDetail->product_id}&numbers[]={$orderDetail->number}";
        })->implode('&');

        $url = '/user/comment/orders/create?' . $parameters;

        return <<<BUTTON
<a href="{$url}"
   class="am-btn am-btn-success anniu">再来一单</a>
BUTTON;
    }
}
