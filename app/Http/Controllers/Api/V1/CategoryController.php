<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\CategoreResource;
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
}
