<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Subscribe
 *
 * @property int $id
 * @property int $user_id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscribe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscribe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscribe query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscribe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscribe whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscribe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscribe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscribe whereUserId($value)
 * @mixin \Eloquent
 * @property int $is_subscribe
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscribe whereIsSubscribe($value)
 */
class Subscribe extends Model
{
    protected $table = 'subscribes';
    protected $fillable = ['email', 'user_id', 'is_subscribe'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
