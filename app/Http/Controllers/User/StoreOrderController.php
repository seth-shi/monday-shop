<?php

namespace App\Http\Controllers\User;

use App\Enums\OrderStatusEnum;
use App\Enums\OrderTypeEnum;
use App\Enums\SettingIndexEnum;
use App\Exceptions\OrderException;
use App\Http\Controllers\Controller;
use App\Jobs\CancelUnPayOrder;
use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserHasCoupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StoreOrderController extends Controller
{
    public function create(Request $request)
    {
        $cars = $request->input('cars', []);
        $ids = $request->input('ids');
        $numbers = $request->input('numbers');

        if (count($ids) === 0 || count($ids) !== count($numbers)) {

            return back()->with('error', '无效的商品');
        }

        $products = Product::query()->findMany($ids);
        if ($products->count() === 0 || $products->count() !== count($numbers)) {

            return back()->with('error', '无效的商品');
        }

        $totalAmount = 0;
        $products->transform(function (Product $product, $i) use ($numbers, &$totalAmount) {

            $product->number = $numbers[$i];
            $product->total_amount = round($product->price * $product->number);
            $totalAmount += $product->total_amount;

            return $product;
        });

        /**
         * @var $user User
         */
        $user = auth()->user();
        $addresses = $user->addresses()->latest()->get();

        // 可用的优惠券
        $today = Carbon::today()->toDateString();
        $coupons = $user->coupons()
                        ->where('start_date', '<=', $today)
                        ->where('end_date', '>=', $today)
                        ->whereNull('used_at')
                        ->where('full_amount', '<=', $totalAmount)
                        ->latest()
                        ->get();

        return view('orders.create', compact('products', 'cars', 'addresses', 'totalAmount', 'coupons'));
    }

    public function store(Request $request)
    {
        /**
         * @var $user User
         * @var $address Address
         */
        $user = auth()->user();
        $address = $user->addresses()->find($request->input('address_id'));
        if (is_null($address)) {

            return responseJsonAsBadRequest('请选择收货地址');
        }

        $order = new Order();
        $order->consignee_name = $address->name;
        $order->consignee_phone = $address->phone;
        $order->consignee_address = $address->format();
        $order->user_id = $user->id;
        $order->type = OrderTypeEnum::COMMON;
        $order->status = OrderStatusEnum::UN_PAY;
        $order->total = OrderStatusEnum::UN_PAY;

        // name

        /**
         * @var $product Product
         * @var $address Address
         */
        $product = Product::query()->where('uuid', $productUuid)->firstOrFail();

        // 明细表
        $detail = $this->buildOrderDetail($product, $number);
        $masterOrder->name = $product->name;
        $masterOrder->total = $detail['total'];
        $masterOrder->save();


        return $masterOrder->details()->create($detail);


        // 当订单超过三十分钟未付款，自动取消订单
        $settingKey = new SettingIndexEnum(SettingIndexEnum::UN_PAY_CANCEL_TIME);
        $delay = Carbon::now()->addMinute(setting($settingKey, 30));
        CancelUnPayOrder::dispatch($masterOrder)->delay($delay);
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
            'number' => $number
        ];
        $attribute['price'] = $product->price;
        $attribute['total'] = ceilTwoPrice($attribute['price'] * $attribute['number']);

        return $attribute;
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
            ->setAttribute('sale_count', $product->sale_count + $number)
            ->save();
    }
}
