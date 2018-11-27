<?php

namespace App\Http\Controllers\User;

use App\Exceptions\OrderException;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Address;
use App\Models\Car;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yansongda\Pay\Pay;

class PaymentsController extends ApiController
{
    /**
     * 限制选择支付页面
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $this->validate($request, ['address_id' => 'required|exists:addresses,id']);

        $product = Product::query()->where('uuid', $request->input('product_id'))->firstOrFail();
        $address = Address::query()->find($request->input('address_id'));

        return view('user.payments.index', [
            'product' => $product,
            'numbers' => $request->input('numbers', 1),
            'address' => $address
        ]);
    }

    /**
     * 生成支付参数的接口
     *
     * @param StoreOrderRequest $request
     * @return string
     * @throws \Exception
     */
    public function store(StoreOrderRequest $request)
    {
        DB::beginTransaction();

        try {

            // 如果有商品 id，证明是单个商品下单。
            // 否则，就是通过购物车直接下单，
            // 但无论如何都得有 address_id
            $masterOrder = $this->newMasterOrder($request);

            if ($request->has('product_id')) {

                $this->storeSingleOrder($masterOrder, $request);
            } else {

                $this->storeCarsOrder($masterOrder);
            }

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withErrors($e->getMessage());
        }

        DB::commit();


        // 生成支付信息
        return $this->buildPayForm($masterOrder, $request->input('pay_method'));
    }


    /**
     * 单个商品直接下单
     *
     * @param Order   $masterOrder
     * @param Request $request
     * @return void
     * @throws OrderException
     */
    protected function storeSingleOrder(Order $masterOrder, Request $request)
    {
        /**
         * @var $product Product
         * @var $address Address
         */
        $product = Product::query()->where('uuid', $request->input('product_id'))->first();

        // 明细表
        $detail = $this->buildOrderDetail($product, $request->input('numbers'));
        $masterOrder->name = $product->name;
        $masterOrder->total = $detail['total'];
        $masterOrder->save();


        $masterOrder->details()->create($detail);
    }


    /**
     * @param Order $masterOrder
     * @throws OrderException
     */
    protected function storeCarsOrder(Order $masterOrder)
    {
        $cars = $this->user()->cars()->with('product')->get();
        if ($cars->isEmpty()) {

            throw new OrderException('购物车为空，请选择商品后再结账');
        }

        // 明细表
        $details = $cars->map(function (Car $car) use ($masterOrder) {

            return $this->buildOrderDetail($car->product, $car->numbers);
        });

        // 商品的名字，用多个商品拼接
        $name = $cars->pluck('product')->pluck('name')->implode('|');
        $name = str_limit($name);

        $masterOrder->name = $name;
        $masterOrder->total = $details->sum('total');
        $masterOrder->save();

        // 订单明细表创建
        $masterOrder->details()->createMany($details->all());

        // 删除购物车完成
        $this->user()->cars()->delete();
    }


    /**
     * 实例化一个主订单
     * @param Request $request
     * @return Order
     */
    protected function newMasterOrder(Request $request)
    {
        /**
         * 主订单的新建
         * @var $address Address
         * @var $masterOrder Order
         */
        $address = Address::query()->find($request->input('address_id'));

        $order = new Order();
        $order->consignee_name = $address->name;
        $order->consignee_phone = $address->phone;
        $order->consignee_address = $address->format();
        $order->user_id = auth()->id();
        $order->pay_type = $request->input('pay_type');

        return $order;
    }

    /**
     * 库存数量
     *
     * @param Product $product
     * @param         $number
     * @throws OrderException
     */
    protected function decProductNumber(Product $product, $number)
    {
        if ($number > $product->count) {
            throw new OrderException("[{$product->name}] 库存数量不足");
        }

        $product->setAttribute('count', $product->count - $number)
                ->setAttribute('safe_count', $product->safe_count + $number)
                ->save();
    }

    /**
     * 构建订单明细
     *
     * @param Product $product
     * @param         $number
     * @return array
     * @throws OrderException
     */
    protected function buildOrderDetail(Product $product, $number)
    {
        // 库存量减少
        $this->decProductNumber($product, $number);

        $attribute =  [
            'product_id' => $product->id,
            'numbers' => $number
        ];
        $attribute['price'] = $product->price;
        $attribute['total'] = ceilTwoPrice($attribute['price'] * $attribute['numbers']);

        return $attribute;
    }

    /**
     * 生成支付订单
     *
     * @param Order $order
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function buildPayForm(Order $order, $payMethod)
    {
        // 创建订单
        $order = [
            'out_trade_no' => $order->no,
            'total_amount' => $order->total,
            'subject' => $order->name,
        ];

        $pay = Pay::alipay(config('pay.ali'));

        if ($payMethod == 'wap') {

            return $pay->wap($order);
        }

        return $pay->web($order);
    }


    /**
     * @return User
     */
    protected function user()
    {
        return auth()->user();
    }

}
