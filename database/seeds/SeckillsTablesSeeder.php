<?php

use Illuminate\Database\Seeder;

class SeckillsTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (setting('is_open_seckill') == 1) {

            \App\Models\Product::query()->take(9)->get()->map(function (\App\Models\Product $product) {

                $number = 20;
                $product->decrement('count', $number);

                $seckill = new \App\Models\Seckill();
                $seckill->category_id = $product->category_id;
                $seckill->product_id = $product->id;
                $seckill->price = $product->price / 0.8;
                $seckill->number = $number;
                $seckill->start_at = "1971-1-1 00:00:00";
                $seckill->end_at = "2038-1-1 00:00:00";
                $seckill->save();
            });
        }
    }
}
