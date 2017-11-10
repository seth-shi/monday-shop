<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class LikesProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all()->pluck('id')->toArray();

        User::all()->each(function($u) use ($products) {

            shuffle($products);
            $start = mt_rand(0, count($products) - 1);
            $product_ids = array_slice($products, $start);

            $u->products()->attach($product_ids);
        });
    }
}
