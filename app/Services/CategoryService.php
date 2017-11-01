<?php

namespace App\Services;

use App\Models\Category;
use App\Models\User;

class CategoryService
{
    /**
     * Indent content has become the conversion classification of the parent
     * @return mixed
     */
    public function getTransformCategories()
    {
        $categories = Category::defaultOrder()->withDepth()->get();

        $categories->transform(function ($category) {

            $category->className = (str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category->depth)) . ($category->ancestors->count() ? '┣━━ ' : ' ') . $category->name;

            $category->parentClass = $category->isRoot() ? '一级分类' : implode(' ➤ ', $category->ancestors->pluck('name')->toArray());

            return $category;
        });

        return $categories;
    }
}