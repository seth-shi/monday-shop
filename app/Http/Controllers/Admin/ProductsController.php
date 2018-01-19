<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ProductTrait;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Spatie\Permission\Models\Role;
use Webpatser\Uuid\Uuid;

class ProductsController extends Controller
{
    use ProductTrait;

    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $products = Product::withCount('users')->orderBy('users_count', 'desc')->get();

        return view('admin.products.index', compact('products'));
    }


    public function create()
    {
        $categories = $this->categoryService->getTransformCategories();

        return view('admin.products.create', compact('categories'));
    }


    public function store(ProductRequest $request)
    {
        list(
            $product_data,
            $product_detail_data,
            $product_images_data,
            $product_attributes_data
            ) = $this->getRequestParam($request);

        $product = Product::create($product_data);
        // add product details data
        $product->productDetail()->create($product_detail_data);
        // add product images data
        $product->productImages()->createMany($product_images_data);
        // add product attributes data
        $product->productAttributes()->createMany($product_attributes_data);

        return back()->with('status', '添加商品成功');
    }

    public function show(Product $product)
    {
        return redirect('/home/products/'. $product->id);
    }


    public function edit(Product $product)
    {
        $categories = $this->categoryService->getTransformCategories();


        return view('admin/products/edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        list(
            $product_data,
            $product_detail_data,
            $product_images_data,
            $product_attributes_data
            ) = $this->getRequestParam($request);

        Product::where('id', $product->id)->update($product_data);

        $product->productDetail()->update($product_detail_data);
        // delete all add product images data
        $product->productImages()->delete();
        $product->productImages()->createMany($product_images_data);
        // delete all add product attributes data
        $product->productAttributes()->delete();
        $product->productAttributes()->createMany($product_attributes_data);

        return back()->with('status', '修改商品成功');
    }

    public function destroy(Product $product)
    {
        $product->productDetail()->delete();
        // delete all add product images data
        $product->productImages()->delete();
        // delete all add product attributes data
        $product->productAttribute()->delete();

        $product->delete();

        return back()->with('status', '删除商品成功');
    }



    /**
     * product attributes format database field
     * @param array $data
     * @return array
     */
    private function getChangeAttrField(array $data)
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


    /**
     * Convert the two-dimensional array into a two-dimensional array index association
     * @param array $data
     * @return array
     */
    private function keyToIndex(array $data)
    {
        $collects = [];

        foreach ($data as $key => $value) {

            foreach ($value as $v) {
                $collects[] = [$key => $v];
            }

        }

        return $collects;
    }

    /**
     * get format request param
     * @param ProductRequest $request
     * @return array
     */
    private function getRequestParam(ProductRequest $request)
    {
        // product table field
        $product_data = $request->only(['category_id', 'name', 'price', 'price_original', 'title']);
        // product thumb use image list first
        $product_data['thumb'] = $request->input('link')[0];
        $product_data['uuid'] = Uuid::generate()->hex;
        $product_data['pinyin'] = pinyin_permalink($product_data['name']);
        $product_data['first_pinyin'] = substr($product_data['pinyin'], 0, 1);

        $product_detail_data = $request->only(['count', 'unit', 'description']);

        $product_images_data = $request->only(['link']);
        $product_images_data = $this->keyToIndex($product_images_data);

        $product_attributes_data = $request->only(['attribute', 'items', 'markup']);
        $product_attributes_data = $this->getChangeAttrField($product_attributes_data);

        return [
            $product_data,
            $product_detail_data,
            $product_images_data,
            $product_attributes_data
        ];
    }
}
