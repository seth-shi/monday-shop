<?php

namespace App\Http\Controllers;

use App\Http\Controllers\User\PaymentsController;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
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
     * @return PaymentsController|\Illuminate\Http\JsonResponse
     */
    public function payNotify(Request $request)
    {

        $pay_data = $request->only(['paysapi_id', 'orderid', 'price', 'realprice', 'orderuid']);
        $pay_data['token'] = config('payment.token');

        ksort($pay_data);
        $temps = md5(implode('', $pay_data));
        $Key = $request->input('key');



        if (md5($temps) != $Key) {
            file_put_contents('pay.log', "校验出错 \r\n", FILE_APPEND);
            return $this->setCode(303)->setMsg('校验出错')->toJson();
        }

        $payment = Payment::query()->where('orderid', $pay_data['orderid'])->first();

        if (! $payment) {
            file_put_contents('pay.log', "不存在此次支付 \r\n", FILE_APPEND);
            return $this->setCode(305)->setMsg('不存在此次支付')->toJson();
        }

        $payment->paysapi_id = $pay_data['paysapi_id'];
        $payment->status = 1;
        $payment->save();

        file_put_contents('pay.log', "{$payment->paysapi_id} \r\n", FILE_APPEND);

        return $this->setMsg('SUCCESS');
    }


    /**
     * 前台跳转的接口
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Yansongda\Pay\Exceptions\InvalidArgumentException
     * @throws \Yansongda\Pay\Exceptions\InvalidConfigException
     * @throws \Yansongda\Pay\Exceptions\InvalidSignException
     */
    public function payReturn(Request $request)
    {
        $latestProducts = Product::query()->latest()->take(9)->get();

        $data = Pay::alipay($this->config)->verify(); // 是的，验签就这么简单！

        $order = Order::query()->latest()->first();

        return view('user.payments.result', compact('order', 'latestProducts'));
    }


}
