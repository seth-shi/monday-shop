<?php

namespace App\Admin\Actions\Post;

use App\Enums\OrderShipStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\User;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OrderReceivedAction extends RowAction
{
    public $name = '确认收货';

    public function handle(Order $order)
    {
        if ($order->status != OrderStatusEnum::PAID) {

            return back()->withErrors('订单未付款', 'error');
        }

        if ($order->ship_status != OrderShipStatusEnum::DELIVERED) {

            return back()->withErrors('订单未发货', 'error');
        }

        $order->ship_status = OrderShipStatusEnum::RECEIVED;
        $order->save();

        return $this->response()->success('确认收货成功.')->refresh();
    }
}
