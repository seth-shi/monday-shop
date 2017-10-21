<?php

namespace App\Repositories;


use App\Models\Category;

class CategoryRepository
{

    public function getAll($orderBy = 'updated_at')
    {
        return Category::orderBy($orderBy, 'desc')->get();
    }

}