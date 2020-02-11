<?php

namespace App\Http\Controllers\User;

use App\Enums\OrderStatusEnum;
use App\Enums\OrderTypeEnum;
use App\Enums\SettingKeyEnum;
use App\Exceptions\OrderException;
use App\Http\Controllers\Controller;
use App\Jobs\CancelUnPayOrder;
use App\Models\Address;
use App\Models\Car;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use App\Utils\OrderUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

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

        // 增加邮费
        $postAmount = \setting(new SettingKeyEnum(SettingKeyEnum::POST_AMOUNT));
        $totalAmount += $postAmount;

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

        return view('orders.create', compact('products', 'cars', 'addresses', 'totalAmount', 'coupons', 'postAmount'));
    }

    public function store(Request $request)
    {
        if (($response = $this->validateRequest($request)) instanceof Response) {

            return $response;
        }


        list($ids, $numbers, $productMap, $address, $couponModel) = $response;

        // 构建出订单所需的详情
        $detailsData = Collection::make($ids)->map(function ($id, $index) use ($numbers, $productMap) {

            return [
                'number' => $numbers[$index],
                'product' => $productMap[$id]
            ];
        });


        DB::beginTransaction();

        try {


            $masterOrder = ($orderUtil = new OrderUtil($detailsData))->make(auth()->id(), $address);

            if (! is_null($couponModel) && $masterOrder->amount < $couponModel->full_amount) {

                throw new \Exception('优惠券门槛金额为 ' . $couponModel->full_amount);
            }

            // 订单价格等于原价 - 优惠价格
            if (! is_null($couponModel)) {

                $masterOrder->amount = $masterOrder->amount > $couponModel->amount ?
                    ($masterOrder->amount - $couponModel->amount) : 0.01;

                $couponModel->used_at = Carbon::now()->toDateTimeString();
                $couponModel->save();

                $masterOrder->coupon_id = $couponModel->id;
                $masterOrder->coupon_amount = $couponModel->amount;
            }

            $masterOrder->save();

            // 创建订单明细
            $details = $orderUtil->getDetails();
            data_set($details, '*.order_id', $masterOrder->id);
            OrderDetail::query()->insert($details);

            // 如果存在购物车，把购物车删除
            $cars = $request->input('cars');
            if (is_array($cars) && ! empty($cars)) {

                Car::query()->where('user_id', auth()->id())->where('id', $cars)->delete();
            }

            // 当订单超过三十分钟未付款，自动取消订单
            $settingKey = new SettingKeyEnum(SettingKeyEnum::UN_PAY_CANCEL_TIME);
            $delay = Carbon::now()->addMinute(setting($settingKey, 30));
            CancelUnPayOrder::dispatch($masterOrder)->delay($delay);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            return responseJsonAsBadRequest($e->getMessage());
        }

        return responseJson(200, '创建订单成功', ['order_id' => $masterOrder->id]);
    }



    private function validateRequest(Request $request)
    {
        /**
         * @var $user User
         * @var $address Address
         */
        $user = auth()->user();

        $ids = $request->input('ids');
        $numbers = $request->input('numbers');

        if (count($ids) === 0 || count($ids) !== count($numbers)) {

            return responseJsonAsBadRequest('无效的商品');
        }

        $productMap = Product::query()->whereIn('uuid', $ids)->get()->mapWithKeys(function (Product $product) {

            return [$product->uuid => $product];
        });
        if (count($productMap) === 0 || count($productMap) !== count($numbers)) {

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

        return [$ids, $numbers, $productMap, $address, $couponModel];
    }
}
