<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\CategoreResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Services\PageServe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(PageServe $serve)
    {
        list($limit, $offset) = $serve->getPageParameters();

        $query = Category::query();

        if ($title = $serve->input('name')) {

            $query->where('title', 'like', "%{$title}%");
        }


        $count = $query->count();
        $categories = $query->orderBy('order')->limit($limit)->offset($offset)->get();
        $categories = CategoreResource::collection($categories);

        return responseJson(200, 'success', $categories, compact('count'));
    }


    public function getProducts(PageServe $serve, $category)
    {
        list($limit, $offset) = $serve->getPageParameters();

        // 排序的字段和排序的值
        $orderField = $serve->input('order_field');
        $orderValue = $serve->input('order_value');

        /**
         * @var $category Category
         */
        $category = Category::query()->findOrFail($category);

        $query = $category->products();


        if ($name = $serve->input('name')) {

            $query->where('name', 'like', "%{$name}%");
        }

        // 获取排序的字段
        $allFields = ['created_at', 'sale_count', 'view_count'];
        $orderField = in_array($orderField, $allFields) ?
            $orderField :
            array_first($allFields);
        $orderValue = $orderValue === 'asc' ? 'asc' : 'desc';


        // 获取数据
        $count = $query->count();
        $products = $query->orderBy($orderField, $orderValue)
                          ->limit($limit)
                          ->offset($offset)
                          ->get();
        $products = ProductResource::collection($products);

        return responseJson(200, 'success', $products, compact('count'));
    }
}
