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
        $products_data = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'products.json');
        $products_data = json_decode($products_data, true);

        $descriptions_data = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'descriptions.json');
        $descriptions_data = json_decode($descriptions_data, true);

        $total = count($products_data) - 1;
        $i = 0;
        foreach ($products_data as $key => $product_data) {

            if ($i ++ > 120) {
                break;
            }
            $product = $this->makeProduct($product_data);

            // product images
            factory(ProductImage::class, ['link' => 'uploads/products/list/' . $product_data['thumb'], 'product_id' => $product->id]);
            factory(ProductImage::class, mt_rand(2, 4))->create(['product_id' => $product->id]);

            // product detail
            factory(ProductDetail::class)->create(['product_id' =>  $product->id, 'description' => $descriptions_data[$key]]);

            // product attributes
            factory(ProductAttribute::class, mt_rand(1, 4))->create(['product_id' =>  $product->id]);

            $bar = intval(($key / $total) * 100);
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
