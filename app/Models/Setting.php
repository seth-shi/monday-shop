<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $key 配置的索引名
 * @property string $value 配置的索引值
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereValue($value)
 * @mixin \Eloquent
 */
class Setting extends Model
{
    protected $fillable = ['index_code', 'value', 'description', 'created_at', 'updated_at'];

    protected $allowTypes = [
        'textarea', 'number', 'switch', 'dateTime', 'text'
    ];

    const CACHE_KEY = 'setting:';


    public static function boot()
    {
        parent::boot();

        static::saving(function (Setting $setting) {

            Cache::forever(static::cacheKey($setting->index_code), $setting->value);
        });
    }

    public static function cacheKey($name)
    {
        return self::CACHE_KEY . $name;
    }
}
