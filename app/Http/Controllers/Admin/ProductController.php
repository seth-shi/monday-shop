<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::withTrashed()->with('category')->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%'.$request->string('q').'%'))->latest('id')->paginate(20)->withQueryString();
        return view('admin.products.index', compact('products'));
    }

    public function edit(string $id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'count' => 'required|integer|min:0',
            'thumb' => 'nullable|string|max:255',
        ]);

        $product->update($data);

        return redirect()->route('admin.products.index')->with('status', '商品已更新');
    }

    public function toggle(string $id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->trashed() ? $product->restore() : $product->delete();
        return back()->with('status', $product->trashed() ? '商品已下架' : '商品已上架');
    }
}
