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


        $i = 0;
        $total = count($product_datas);
        foreach ($product_datas as $product_data) {

            $product = $this->makeProduct($product_data);

            ProductImage::create([
                'link' => 'uploads/products/list/' . $product_data['thumb'],
                'product_id' => $product->id
            ]);
            // product images
            $count = mt_rand(2, 4);
            factory(ProductImage::class, $count)->create(['product_id' => $product->id]);

            // product attribute
            factory(ProductDetail::class, 1)->create(['product_id' =>  $product->id]);

            // product attr
            $count = mt_rand(1, 4);
            factory(ProductAttribute::class, $count)->create(['product_id' =>  $product->id]);

            $bar = intval((++ $i / $total) * 100);
            echo "seeding: [products] .... {$bar} % \r";
        }

    }

    protected function makeProduct(array $product)
    {
        $product['uuid'] = Uuid::generate()->hex;
        $product['price_original'] = ($product['price'] * (mt_rand(12, 18)/10));
        $product['pinyin'] = pinyin_permalink($product['name']);
        $product['first_pinyin'] = substr($product['pinyin'], 0, 1);
        $product['thumb'] = 'uploads/products/list/' . $product['thumb'];
        $product['category_id'] = \App\Models\Category::inRandomOrder()->first()->id;

        return Product::create($product);
    }
}
