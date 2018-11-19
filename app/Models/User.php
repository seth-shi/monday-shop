<?php

namespace App\Models;

use App\Mail\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;


    const DEFAULT_AVATARS = [
        '1.jpg',
        '2.jpg',
        '3.jpg',
        '4.jpg',
        '5.jpg',
        '6.jpg',
        '7.jpg',
        '8.jpg',
        '9.jpg',
    ];
    // 用户性别
    CONST MAN = 1;
    CONST WOMAN = 0;
    CONST SEXES = [
        self::MAN => '男',
        self::WOMAN => '女'
    ];

    CONST ACTIVE_STATUS = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'sex', 'password', 'active_token', 'is_active', 'avatar',
        'github_id', 'github_name', 'qq_id', 'qq_name', 'weibo_id', 'weibo_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getAvatarAttribute($avatar)
    {
        return imageUrl($avatar);
    }

    /**
     * 获取隐藏部分的名字
     * @param $attribute
     * @return string
     */
    public function getHiddenNameAttribute($attribute)
    {
        $lastStr = mb_substr($this->name, 0, 1, 'utf-8');

        $hiddenStr = str_repeat('*', mb_strlen($this->name, 'utf-8') - 1);

        return $lastStr . $hiddenStr;
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function subscribe()
    {
        return $this->hasOne(Subscribe::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * 获取订单明细用以评论
     */
    public function orderDetails()
    {
        return $this->hasManyThrough(OrderDetail::class, Order::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'likes_products');
    }



    /**
     * rewrite send reset password email
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        Mail::to($this->email)
            ->queue(new ResetPassword($token));
    }


    /**
     * 初始化头像
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {

            if (! isset($model->attributes['avatar'])) {
                $model->attributes['avatar'] = 'avatars/default/' . array_random(User::DEFAULT_AVATARS);
            }

            // TODO, 之后增加一个配置表
            if (! isset($model->attributes['password'])) {
                $model->attributes['password'] = bcrypt('123456');
            }

        });
    }
}
