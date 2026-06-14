<?php

namespace App\Support;

use App\Enums\OrderShipStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Models\Order;

final class OrderPresenter
{
    public static function status(Order $order): string
    {
        $status = (int) $order->status;
        $shipStatus = (int) $order->ship_status;

        if ($status === OrderStatusEnum::PAID) {
            return match ($shipStatus) {
                OrderShipStatusEnum::PENDING => '待发货',
                OrderShipStatusEnum::DELIVERED => '待收货',
                OrderShipStatusEnum::RECEIVED => '已收货',
                default => '已支付',
            };
        }

        return match ($status) {
            OrderStatusEnum::UN_PAY => '待付款',
            OrderStatusEnum::UN_PAY_CANCEL => '已取消',
            OrderStatusEnum::REFUND => '已退款',
            OrderStatusEnum::APPLY_REFUND => '退款处理中',
            OrderStatusEnum::TIMEOUT_CANCEL => '超时取消',
            OrderStatusEnum::COMPLETED => '已完成',
            default => '未知状态',
        };
    }

    public static function actions(Order $order): array
    {
        $status = (int) $order->status;
        $shipStatus = (int) $order->ship_status;

        return match ($status) {
            OrderStatusEnum::UN_PAY => [
                ['type' => 'link', 'label' => '去付款', 'url' => url("/user/pay/orders/{$order->id}/again"), 'tone' => 'primary'],
                ['type' => 'link', 'label' => '取消订单', 'url' => url("/user/orders/{$order->id}/cancel"), 'tone' => 'secondary'],
            ],
            OrderStatusEnum::PAID => match ($shipStatus) {
                OrderShipStatusEnum::DELIVERED => [['type' => 'confirm', 'label' => '确认收货', 'url' => url("/user/orders/{$order->id}/shipped"), 'tone' => 'primary']],
                OrderShipStatusEnum::RECEIVED => [['type' => 'comment', 'label' => '评价订单', 'url' => url("/user/orders/{$order->id}/complete"), 'tone' => 'primary', 'score' => $order->score]],
                default => [['type' => 'refund', 'label' => '申请退款', 'url' => url("/user/pay/orders/{$order->id}/refund"), 'tone' => 'secondary']],
            },
            OrderStatusEnum::UN_PAY_CANCEL, OrderStatusEnum::COMPLETED, OrderStatusEnum::TIMEOUT_CANCEL => [
                ['type' => 'link', 'label' => '再次购买', 'url' => self::buyAgainUrl($order), 'tone' => 'primary'],
                ['type' => 'delete', 'label' => '删除订单', 'url' => url("/user/orders/{$order->id}"), 'tone' => 'secondary'],
            ],
            default => [],
        };
    }

    private static function buyAgainUrl(Order $order): string
    {
        $order->loadMissing('details.product');
        $query = $order->details->map(fn ($detail) => 'ids[]='.urlencode($detail->product?->uuid ?? '').'&numbers[]='.$detail->number)->implode('&');
        return url('/user/comment/orders/create').'?'.$query;
    }
}
