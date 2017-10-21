<?php

namespace App\Repositories;


use App\Models\Admin;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CategoryRepository
{

    public function getAll($orderBy = 'updated_at')
    {
        return Category::orderBy($orderBy, 'desc')->get();
    }

}