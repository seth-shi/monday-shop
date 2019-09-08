<?php

namespace App\Admin\Actions\Post;

use App\Enums\OrderShipStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\User;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OrderShipAction extends RowAction
{
    public $name = '发货';

    public function handle(Order $order, Request $request)
    {
        if ($order->status != OrderStatusEnum::PAID) {

            return $this->response()->error('订单未付款');
        }

        $company = $request->input('company');
        $no = $request->input('no');
        if (empty($company) || empty($no)) {

            return $this->response()->error('必填项不能为空');
        }

        $order->ship_status = OrderShipStatusEnum::DELIVERED;
        $order->express_company = $company;
        $order->express_no = $no;
        $order->save();

        return $this->response()->success('发货成功.')->refresh();
    }

    public function form()
    {
        $this->text('company', '物流公司')->required();
        $this->text('no', '物流单号')->required();
    }
}
