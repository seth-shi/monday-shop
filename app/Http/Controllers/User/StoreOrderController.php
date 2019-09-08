<?php

namespace App\Http\Controllers\User;

use App\Enums\OrderStatusEnum;
use App\Enums\OrderTypeEnum;
use App\Enums\SettingKeyEnum;
use App\Exceptions\OrderException;
use App\Http\Controllers\Controller;
use App\Jobs\CancelUnPayOrder;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserHasCoupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreOrderController extends Controller
{
    public function create(Request $request)
    {
        /**
         * @var $user User
         */
        $user = auth()->user();


        $cars = $request->input('cars', []);
        $ids = $request->input('ids');
        $numbers = $request->input('numbers');

        if (count($ids) === 0 || count($ids) !== count($numbers)) {

            return back()->with('error', '无效的商品');
        }

        $products = Product::query()->whereIn('uuid', $ids)->get();
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

        $cars = $request->input('cars', []);
        $ids = $request->input('ids');
        $numbers = $request->input('numbers');

        if (count($ids) === 0 || count($ids) !== count($numbers)) {

            return responseJsonAsBadRequest('无效的商品');
        }

        $products = Product::query()->whereIn('uuid', $ids)->get();
        if ($products->count() === 0 || $products->count() !== count($numbers)) {

            return responseJsonAsBadRequest('无效的商品.');
        }


        $address = $user->addresses()->find($request->input('address_id'));
        if (is_null($address)) {

            return responseJsonAsBadRequest('请选择收货地址');
        }


        // 查看是否有优惠券的价格
        $couponModel = null;
        if ($couponId = $request->input('coupon_id')) {

            $couponModel = $user->coupons()->find($couponId);
            if (is_null($couponModel)) {

                return responseJsonAsBadRequest('无效的优惠券');
            }

            $today = Carbon::today();
            $startDate = Carbon::make($couponModel->start_date) ?? Carbon::tomorrow();
            $endDate = Carbon::make($couponModel->end_date) ?? Carbon::yesterday();
            if ($today->lt($startDate) || $today->gt($endDate)) {

                return responseJsonAsBadRequest('优惠券已过使用期');
            }

            if (! is_null($couponModel->used_at)) {

                return responseJsonAsBadRequest('优惠券已使用过');
            }
        }


        DB::beginTransaction();

        try {

            $originAmount = 0;
            $details = $products->map(function (Product $product, $i) use ($numbers, &$originAmount) {

                $number = $numbers[$i];

                // 此处库存，是查询出来的库存
                if ($number > $product->count) {
                    throw new OrderException("{$product->name} 库存数量不足");
                }

                // 这里，由于库存的减少会带来超卖的问题
                // 所以我们使用乐观锁解决这个问题
                $updated = Product::query()
                                  ->whereKey($product->id)
                                  ->where('count', '>=', $number)
                                  ->update([
                                      'count' => DB::raw("count-{$number}"),
                                      'sale_count' => DB::raw("sale_count+{$number}"),
                                  ]);
                if ($updated === 0) {

                    throw new \Exception("{$product->name}商品库存不足");
                }

                $attribute =  [
                    'product_id' => $product->id,
                    'number' => $number
                ];
                $attribute['price'] = $product->price;
                $attribute['total'] = ceilTwoPrice($attribute['price'] * $attribute['number']);

                $originAmount += $attribute['total'];

                return $attribute;
            });

            if (! is_null($couponModel) && $originAmount < $couponModel->full_amount) {

                throw new \Exception('优惠券门槛金额为 ' . $couponModel->full_amount);
            }

            $order = new Order();
            $order->consignee_name = $address->name;
            $order->consignee_phone = $address->phone;
            $order->consignee_address = $address->format();
            $order->user_id = $user->id;
            $order->type = OrderTypeEnum::COMMON;
            $order->status = OrderStatusEnum::UN_PAY;
            $order->origin_amount = $originAmount;

            // 订单价格等于原价 - 优惠价格
            $totalAmount = $originAmount;
            if (! is_null($couponModel)) {

                $totalAmount -= $couponModel->amount;
                $couponModel->used_at = Carbon::now()->toDateTimeString();
                $couponModel->save();

                if ($totalAmount <= 0) {

                    $totalAmount = 0.01;
                }

                $order->coupon_amount = $originAmount - $totalAmount;
            }
            $order->amount = $totalAmount;
            $order->save();

            // 创建订单明细
            $details = $details->all();
            data_set($details, '*.order_id', $order->id);
            OrderDetail::query()->insert($details);

            // 如果存在购物车，把购物车删除
            if (is_array($cars) && ! empty($cars)) {

                $user->cars()->whereIn('id', $cars)->delete();
            }

            // 当订单超过三十分钟未付款，自动取消订单
            $settingKey = new SettingKeyEnum(SettingKeyEnum::UN_PAY_CANCEL_TIME);
            $delay = Carbon::now()->addMinute(setting($settingKey, 30));
            CancelUnPayOrder::dispatch($order)->delay($delay);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            return responseJsonAsBadRequest($e->getMessage());
        }

        return responseJson(200, '创建订单成功', ['order_id' => $order->id]);
    }
}
