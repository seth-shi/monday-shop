<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ScoreLog
 *
 * @property int $id
 * @property int|null $rule_id 积分规则的主键
 * @property int $user_id 得到积分的用户
 * @property string $description score_rule 表的同名字段替换后的值
 * @property int $score 得到了多少积分
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreLog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreLog whereRuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreLog whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreLog whereUserId($value)
 * @mixin \Eloquent
 */
class ScoreLog extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
