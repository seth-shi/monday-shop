<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Api\ApiController;
use App\Models\Address;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Webpatser\Uuid\Uuid;

class PaymentsController extends ApiController
{
    public function index(Request $request)
    {
        $product = Product::find($request->input('_product_id'));
        $address = Address::find($request->input('_address_id'));

        return view('user.payments.index', [
            'product' => $product,
            'numbers' => $request['_numbers'],
            'address' => $address
        ]);
    }

    public function pay(Request $request)
    {
        if (($validator = $this->validatePayParam($request->all()))->fails()) {
            return $this->setCode(303)->setMsg($validator->errors()->first());
        }
        
        $pay_data = $this->getFormData($request->only(['price', 'istype', 'orderuid', 'goodsname']));


        if (! $payment = Payment::create($pay_data)) {
            return $this->setCode(402)->setMsg('服务器异常，请稍后再试');
        }

        return $this->setMsg('生成支付信息成功')->setData($pay_data)->toJson();
    }

    public function paynotify(Request $request)
    {
        $pay_data = $request->only(['paysapi_id', 'orderid', 'price', 'realprice', 'orderuid']);
        $pay_data['token'] = config('payment.token');

        ksort($pay_data);
        $temps = implode('', $pay_data);
        $Key = $request->input('key');

        if (md5($temps) != $Key) {
            return $this->setCode(303)->setMsg('校验出错');
        }

        $payment = Payment::where('orderid', $pay_data['orderid'])->first();

        if (! $payment) {
            return $this->setCode(305)->setMsg('不存在此次支付');
        }

        $payment->paysapi_id = $pay_data['paysapi_id'];
        $payment->status = 1;
        $payment->save();

        file_put_contents('pay.log', "{$payment->paysapi_id} \r\n", FILE_APPEND);

        return $this->setMsg('SUCCESS');
    }

    public function payreturn()
    {
        $orderid = $_GET["orderid"];

        // query database
        //此处在您数据库中查询：此笔订单号是否已经异步通知给您付款成功了。如成功了，就给他返回一个支付成功的展示。
        echo "恭喜，支付成功!，订单号：".$orderid;
    }

    private function validatePayParam(array $data)
    {
        return Validator::make($data, [
            'price' => 'required|numeric',
            'istype' => 'in:1,2',
            'orderuid' => 'required|exists:users,id',
            'goodsname' => 'required|exists:products,name'
        ]);
    }

    private function getFormData(array $data)
    {
        $sys_data = [
            'uid' => config('payment.uid'),
            'token' => config('payment.token'),
            'notify_url' => config('payment.notify_url'),
            'return_url' => config('payment.return_url'),
            'orderid' => Uuid::generate()->hex,
        ];

        $data = array_merge($sys_data, $data);
        ksort($data);
        $data['key'] = md5(implode('', $data));

        return $data;
    }
}
