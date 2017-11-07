<?php

namespace App\Http\Controllers\Home;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::inRandomOrder()->take(9)->get(['id', 'name'])->split(3);

        $productPinyins = Product::groupBy('first_pinyin')->get(['first_pinyin']);

        return view('home.products.index', compact('products', 'productPinyins'));
    }

    public function getProductsByPinyin($pinyin)
    {
        $products = Product::where('first_pinyin', $pinyin)->get(['id', 'name'])->split(3);

        return $products;
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
