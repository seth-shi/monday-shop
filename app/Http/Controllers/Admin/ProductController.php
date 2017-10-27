<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    public function index()
    {
        return 1111;
    }


    public function create()
    {
        $categories = Category::defaultOrder()->withDepth()->get();

        return view('admin.products.create', compact('categories'));
    }


    public function store(ProductRequest $request)
    {
        dd($request->all());
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
