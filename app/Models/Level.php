<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Level
 *
 * @property int $id
 * @property string $name 等级的名字
 * @property int $level 等级
 * @property string|null $icon 等级的图标
 * @property int $min_score 阶级分的下限
 * @property int $can_delete 是否可以删除
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Level newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Level newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Level query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Level whereCanDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Level whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Level whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Level whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Level whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Level whereMinScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Level whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Level whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Level extends Model
{

}
