<?php

namespace App\Http\Controllers;

use App\Admin\Transforms\OrderPayTypeTransform;
use App\Enums\OrderPayTypeEnum;
use App\Enums\OrderStatusEnum;
use App\Http\Controllers\User\PaymentController;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yansongda\Pay\Pay;

class PaymentNotificationController extends Controller
{
    protected $config;


    public function __construct()
    {
        $this->config = config('pay.ali');
    }


    /**
     * 后台通知的接口
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function payNotify(Request $request)
    {
        $alipay = Pay::alipay($this->config);

        // TODO , 加一个轮询接口配合后台通知修改订单状态
        // 后台异步通知接口有可能会因为网络问题接收不到
        // 使用轮询插接订单状态，如果支付了停止轮询
        try{
            $data = $alipay->verify(); // 是的，验签就这么简单！

            // 验证 app_id
            // 可：判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            if ($data->get('app_id') == $this->config['app_id']) {

                // 支付成功
                if ($data->get('trade_status') == 'TRADE_SUCCESS') {

                    // 更新订单
                    $order = Order::query()->where('no', $data->get('out_trade_no'))->firstOrFail();
                    $order->paid_at = $data->get('notify_time');
                    $order->pay_no = $data->get('trade_no');
                    $order->pay_amount = $data->get('receipt_amount');
                    $order->status = OrderStatusEnum::PAID;
                    $order->pay_type = OrderPayTypeEnum::ALI;
                    $order->save();
                }
            }

            Log::debug('Alipay notify', $data->all());
        } catch (\Exception $e) {

            Log::debug('Alipay notify', $e->getMessage());
        }

        return $alipay->success();
    }


    /**
     * 前台跳转的接口
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payReturn()
    {
        $latestProducts = Product::query()->latest()->take(9)->get();

        $order = null;

        try {

            $data = Pay::alipay($this->config)->verify();

            $order = Order::query()->where('no', $data->get('out_trade_no'))->firstOrFail();

        } catch (\Exception $e) {

        }

        return view('user.payments.result', compact('order', 'latestProducts'));
    }


}
