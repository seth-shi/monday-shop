<?php

namespace App\Http\Controllers\Home;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    public function index()
    {
        return view('home.products.index');
    }




    public function show(Product $product)
    {
        $recommendProducts = Product::where('category_id', $product->category_id)->take(5)->get();

        return view('home.products.show', compact('product', 'recommendProducts'));
    }

    public function edit(Product $product)
    {
        //
    }


    public function update(Request $request, Product $product)
    {
        //
    }


    public function destroy(Product $product)
    {
        //
    }
}
