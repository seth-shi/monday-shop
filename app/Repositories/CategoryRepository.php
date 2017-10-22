<?php

namespace App\Repositories;


use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryRepository
{

    public function getAllWithDepath()
    {
        return Category::defaultOrder()->withDepth()->get();
    }

    public function find($id)
    {
        return Category::find($id);
    }

    public function create(array $fileds)
    {
        if (is_null($fileds['parent_id']) || empty($fileds['parent_id'])) {
            return Category::create($fileds);
        }

        try {
            return Category::findOrFail($fileds['parent_id'])->children()->create($fileds);
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

}