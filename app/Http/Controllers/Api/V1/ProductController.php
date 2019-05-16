<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function show($uuid)
    {
        $product = Product::query()->where('uuid', $uuid)->firstOrFail();
        $product->load('detail');

        // 直接使用缓存
        $today = Carbon::today()->toDateString();
        Cache::increment($product->getViewCountKey($today));

        return responseJson(200, 'success', new ProductResource($product));
    }
}
