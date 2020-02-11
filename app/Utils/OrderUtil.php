<?php

namespace App\Utils;

use App\Enums\OrderStatusEnum;
use App\Enums\OrderTypeEnum;
use App\Enums\SettingKeyEnum;
use App\Exceptions\OrderException;
use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderUtil
{
    protected $orderName = '商城订单';
    protected $totalAmount = 0;

    protected $details = [];

    protected $hooks = [];


    /**
     * 每一个 detail 包含商品，和数量
     */
    public function __construct($details)
    {
        $this->details = Collection::make($details)->map(function ($detail) {

            $number = $detail['number'] ?? 1;
            $product = $detail['product'];

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

            $this->totalAmount += $attribute['total'];

            $tmpName = "{$product->name}*{$number}";
            if (strlen($this->orderName) + strlen($tmpName) <= 50) {
                $this->orderName .= $tmpName;
            }

            return $attribute;

        })->all();

    }

    /**
     * @param $buyUserId
     * @param Address $address
     * @return Order
     */
    public function make($buyUserId, Address $address)
    {
        // 增加运费
        $postAmount = \setting(new SettingKeyEnum(SettingKeyEnum::POST_AMOUNT));
        $this->totalAmount += $postAmount;

        $order = new Order();
        $order->consignee_name = $address->name;
        $order->consignee_phone = $address->phone;
        $order->consignee_address = $address->format();
        $order->user_id = $buyUserId;
        $order->type = OrderTypeEnum::COMMON;
        $order->status = OrderStatusEnum::UN_PAY;
        $order->name = $this->orderName;

        $order->post_amount = $postAmount;
        $order->origin_amount = $this->totalAmount;
        $order->amount = $this->totalAmount;


        return $order;
    }

    /**
     * @return array
     */
    public function getDetails()
    {
        return $this->details;
    }

    public function setOrderName($orderName)
    {
        $this->orderName = $orderName;
        return $this;
    }
}
