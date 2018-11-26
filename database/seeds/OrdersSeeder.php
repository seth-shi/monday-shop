<?php

use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{

    protected $faker;

    /**
     * OrdersSeeder constructor.
     *
     * @param $faker
     */
    public function __construct(\Faker\Generator $faker)
    {
        $this->faker = $faker;
    }


    public function run()
    {

        for ($k = 0; $k < 9; ++ $k) {
            /**
             * @var $user User
             * @var $address Address
             * @var $product Product
             */
            $user = User::query()->inRandomOrder()->first();
            $address = $user->addresses()->first();
            $user_id = $user->getKey();

            $masterOrder = new Order();
            $masterOrder->consignee_name = $address->name;
            $masterOrder->consignee_phone = $address->phone;
            $masterOrder->consignee_address = $address->format();
            $masterOrder->user_id = $user_id;


            // 随机几个明细
            $data = [];
            for ($i = 0, $l = mt_rand(1, 4); $i < $l; ++ $i) {

                $product = Product::query()->inRandomOrder()->first();

                $numbers = mt_rand(1, 9);
                $price = $product->price;
                $total = ceilTwoPrice($price * $numbers);
                $product_id = $product->getKey();

                $masterOrder->total += $total;
                $data[] = compact('numbers', 'price', 'total', 'product_id');

                $product->decrement('count', $numbers);
                $product->increment('safe_count', $numbers);
            }

            // 商品数量减少

            $masterOrder->save();
            $masterOrder->details()->createMany($data)->map(function (\App\Models\OrderDetail $detail) use ($masterOrder) {

                $detail->comment()->create(
                    [
                        'user_id' => $masterOrder->user_id,
                        'product_id' => $detail->product_id,
                        'order_id' => $masterOrder->id,
                        'content' => $this->faker->text(50),
                        'score' => mt_rand(3, 5)
                    ]
                );
                $detail->is_commented = true;
                $detail->save();
            });
        }
    }
}
