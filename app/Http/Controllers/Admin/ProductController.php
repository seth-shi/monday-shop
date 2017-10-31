<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
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
        $product = $request->only(['category_id', 'name', 'price', 'price_original']);
        // product thumb use image list first
        $product['thumb'] = $request->input('image')[0];
        $product['uuid'] = Uuid::generate()->hex;

        Product::create($product);

        dd($product, $request->all());
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
}
