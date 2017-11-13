<?php

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Webpatser\Uuid\Uuid;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $product_datas = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'products.json');
        $product_datas = json_decode($product_datas, true);

        foreach ($product_datas as $product_data) {

            $product_data['thumb'] = $faker->imageUrl(800, 600);
            $product = $this->makeProduct($product_data);

            // product images
            $count = mt_rand(3, 5);
            factory(ProductImage::class, $count)->create(['product_id' => $product->id]);

            // product detail
            factory(ProductDetail::class, 1)->create(['product_id' =>  $product->id]);

            // product attribute
            $count = mt_rand(1, 3);
            factory(ProductAttribute::class, $count)->create(['product_id' =>  $product->id]);
        }

    }

    protected function makeProduct(array $product)
    {
        $product['uuid'] = Uuid::generate()->hex;
        $product['price_original'] = ($product['price'] * (mt_rand(12, 18)/10));
        $product['pinyin'] = pinyin_permalink($product['name']);
        $product['first_pinyin'] = substr($product['pinyin'], 0, 1);
        $product['category_id'] = \App\Models\Category::inRandomOrder()->first()->id;

        return Product::create($product);
    }
}
