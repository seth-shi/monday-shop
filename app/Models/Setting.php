<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['index_name', 'value', 'description', 'created_at', 'updated_at'];

    protected $allowTypes = [
        'textarea', 'number', 'switch', 'dateTime', 'text'
    ];

    public function getTypeAttribute($value)
    {
        if (in_array($value, $this->allowTypes)) {

            return $value;
        }

        return 'text';
    }
}
