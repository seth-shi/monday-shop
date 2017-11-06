<?php

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class, 100)->create()->each(function ($p) {

            // product images
            $count = mt_rand(3, 5);
            factory(ProductImage::class, $count)->create(['product_id' => $p->id]);

            // product detail
            factory(ProductDetail::class, 1)->create(['product_id' =>  $p->id]);

            // product attribute
            $count = mt_rand(1, 3);
            factory(ProductAttribute::class, $count)->create(['product_id' =>  $p->id]);
        });
    }
}
