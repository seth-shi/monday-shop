<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\ProductDetail;
use App\Models\User;
use Webpatser\Uuid\Uuid;

class ProductController extends Controller
{

    public function index()
    {
        dd((new User())->first());
        return 1111;
    }


    public function create()
    {
        $categories = Category::defaultOrder()->withDepth()->get();

        return view('admin.products.create', compact('categories'));
    }


    public function store(ProductRequest $request)
    {
        // product table field
        $product_data = $request->only(['category_id', 'name', 'price', 'price_original']);
        // product thumb use image list first
        $product_data['thumb'] = $request->input('image')[0];
        $product_data['uuid'] = Uuid::generate()->hex;

        $product_detail_data = $request->only(['count', 'unit', 'description']);

        $product_images_data = $request->only(['image']);
        $product_images_data = $this->keyToIndex($product_images_data);

        $product_attributes_data = $request->only(['attribute', 'items', 'markup']);
        $product_attributes_data = $this->getChangeAttrField($product_attributes_data);


        $product = Product::create($product_data);
        // add product details data
        $product->productDetails()->create($product_detail_data);
        // add product images data
        $product->productImages()->createMany($product_images_data);
        // add product attributes data
        $product->productAttribute()->createMany($product_attributes_data);


        dd($product);
    }

    public function show(Product $product)
    {
        //
    }


    public function edit(Product $product)
    {
        //
    }

    public function update(ProductRequest $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }

    protected function getChangeAttrField(array $data)
    {
        $data = collect($data);
        $collects = [];

        foreach ($data->first() as $key => $value) {
            $collects[] = [
                'attribute' => $data['attribute'][$key],
                'items' => $data['items'][$key],
                'markup' => $data['markup'][$key],
            ];
        }

        return $collects;
    }

    protected function keyToIndex(array $data)
    {
        $collects = [];

        foreach ($data as $key => $value) {

            foreach ($value as $v) {
                $collects[] = [$key => $v];
            }

        }

        return $collects;
    }
}
