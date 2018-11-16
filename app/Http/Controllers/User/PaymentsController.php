<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\PayRequest;
use App\Jobs\CreatePayment;
use App\Models\Address;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Validator;
use Webpatser\Uuid\Uuid;

class PaymentsController extends ApiController
{
    public function index(Request $request)
    {
        $product = Product::query()->where('uuid', $request->input('_product_id'))->firstOrFail();
        $address = Address::query()->find($request->input('_address_id'));

        return view('user.payments.index', [
            'product' => $product,
            'numbers' => $request['_numbers'],
            'address' => $address
        ]);
    }

    /**
     * 生成支付参数的接口
     *
     * @param PayRequest $request
     * @return string
     * @throws \Exception
     */
    public function pay(PayRequest $request)
    {
        // 获取订单参数
        $baseData = $request->only(['price', 'istype', 'orderuid', 'goodsname']);
        $payData = $this->buildPayData($baseData);

        // 创建订单
        $baseData['orderid'] = $payData['orderid'];
        Payment::query()->create($baseData);


        // 生成支付的 form
        $form = $this->getPayForm($payData);

        return $form;
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
     */
    public function payReturn(Request $request)
    {
        // TODO The query model causes an infinite refresh of the payment callback jump
        dd($request->all());

        $payment = Payment::query()->where('orderid', $request->input('orderid'))->first();

        dd($request->all());

        return view('user.payments.result', compact('payment'));
    }

    /**
     * 生成支付信息, 排序加密参数
     *
     * @param array $data
     * @return array
     * @throws \Exception
     */
    private function buildPayData(array $data)
    {
        $sysData = [
            'uid' => config('payment.uid'),
            'token' => config('payment.token'),
            'notify_url' => config('payment.notify_url'),
            'return_url' => config('payment.return_url'),
            'orderid' => Uuid::generate()->hex,
        ];

        if (mb_strlen($data['goodsname'], 'utf8') > 8) {
            $data['goodsname'] = mb_substr($data['goodsname'], 0, 8, 'utf8');
        }

        $data = array_merge($sysData, $data);
        ksort($data);
        $data['key'] = md5(implode('', $data));

        unset($data['token']);

        return $data;
    }

    /**
     * 获取支付表单
     *
     * @param array $attributes
     * @return string
     */
    protected function getPayForm(array $attributes)
    {
        $inputs = '';
        foreach ($attributes as $key => $val) {

            $key = htmlspecialchars($key);
            $val = htmlspecialchars($val);

            $inputs .= "<input name='{$key}' value='{$val}' >";
        }

        $form = <<<html
<form style="display: none;" method='post' id="pay_form" action='https://pay.paysapi.com'>
{$inputs}
</form>
<script>
    document.getElementById('pay_form').submit();
</script>
html;

        return $form;
    }
}
