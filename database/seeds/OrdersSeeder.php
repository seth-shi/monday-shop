<?php

use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{

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
            $address = $address->format();
            $user_id = $user->getKey();

            $masterOrder = new Order(compact('user_id', 'address'));


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
            }


            $masterOrder->save();
            $masterOrder->details()->createMany($data);
        }
    }
}
