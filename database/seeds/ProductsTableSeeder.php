<?php

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ProductsTableSeeder extends Seeder
{

    protected $pictureBasePath = 'products/list/';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productsData = $this->buildCollectionByJsonFile(__DIR__ . '/../data/products.json');
        $contentsData = $this->buildCollectionByJsonFile(__DIR__ . '/../data/descriptions.json');
        $picturesData = $this->buildCollectionByJsonFile(__DIR__ . '/../data/pictures.json')->map(function ($picture) {
            return $this->pictureBasePath . $picture;
        });


        $count = count($productsData) - 1;
        $productsData->map(function ($productData, $index) use ($count, $contentsData, $picturesData) {

            /**
             * @var $product Product
             */
            $product = $this->makeProduct($productData, $picturesData);

            // product detail
            $product->detail()->create(['content' => $contentsData[$index]]);

            $bar = intval(($index / $count) * 100);
            echo "seeding: [products] .... {$bar} % \r";
        });


        echo "\n";

    }

    /**
     * @param $file
     * @return \Illuminate\Support\Collection
     */
    protected function buildCollectionByJsonFile($file)
    {
        $data = file_get_contents($file);
        return collect(json_decode($data, true));
    }

    /**
     * @param array      $product
     * @param Collection $pictures
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function makeProduct(array $product, Collection $pictures)
    {
        $product['original_price'] = ($product['price'] * (mt_rand(12, 18)/10));
        $product['thumb'] = $this->pictureBasePath . $product['thumb'];
        $product['count'] = mt_rand(999, 99999);
        $product['category_id'] = \App\Models\Category::query()->inRandomOrder()->first()->id;
        // 图片的多图
        $product['pictures'] = $pictures->random(mt_rand(2, 4));

        return Product::query()->create($product);
    }
}
