<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categorys';
    protected $fillable = ['name', 'pid'];

}
