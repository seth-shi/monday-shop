<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['index_name', 'value', 'description', 'created_at', 'updated_at'];
}
