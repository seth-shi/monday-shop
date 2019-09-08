<?php

namespace App\Models;

use App\Enums\SettingKeyEnum;
use App\Enums\SiteCountCacheEnum;
use App\Enums\UserSourceEnum;
use App\Enums\UserStatusEnum;
use App\Mail\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $name
 * @property int $sex
 * @property string|null $email
 * @property string $password
 * @property string $avatar 用户的头像
 * @property int|null $github_id github第三方登录的ID
 * @property string|null $github_name github第三方登录的用户名
 * @property string|null $qq_id
 * @property string|null $qq_name
 * @property string|null $weibo_id
 * @property string|null $weibo_name
 * @property int $login_count 登录次数
 * @property int $source 用户的来源
 * @property string|null $active_token 邮箱激活的token
 * @property int $is_active 用户是否激活
 * @property int $is_init_name 是否是初始用户名，是的话，可以修改用户名
 * @property int $is_init_email 是否是初始邮箱，是的话可以修改邮箱
 * @property int $is_init_password 是否是初始密码，是的话可以不用输入旧密码直接修改
 * @property string|null $remember_token laravel中的记住我
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Address[] $addresses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Car[] $cars
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read string $hidden_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderDetail[] $orderDetails
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read \App\Models\Subscribe $subscribe
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereActiveToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereGithubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereGithubName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsInitEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsInitName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsInitPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLoginCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereQqId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereQqName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereWeiboId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereWeiboName($value)
 * @mixin \Eloquent
 * @property int $score_all 用户的总积分
 * @property int $score_now 用户剩余的积分
 * @property int $login_days 用户连续登录天数
 * @property string|null $last_login_date 上一次登录的日期,用于计算连续登录
 * @property string|null $auth_token
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserHasCoupon[] $coupons
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ScoreLog[] $scoreLogs
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAuthToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastLoginDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLoginDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereScoreAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereScoreNow($value)
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;


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
        return assertUrl($avatar);
    }

    /**
     * 获取隐藏部分的名字
     * @param $attribute
     * @return string
     */
    public function getHiddenNameAttribute($attribute)
    {
        // 第三方登录的用户没有名字
        if (is_null($this->name)) {
            return 'xxx';
        }

        $lastStr = mb_substr($this->name, 0, 1, 'utf-8');

        $hiddenStr = str_repeat('*', mb_strlen($this->name, 'utf-8') - 1);

        return $lastStr . $hiddenStr;
    }


    public function coupons()
    {
        return $this->hasMany(UserHasCoupon::class, 'user_id');
    }

    public function scoreLogs()
    {
        return $this->hasMany(ScoreLog::class, 'user_id');
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

        static::creating(function ($model) {

            if (! isset($model->attributes['avatar'])) {
                $model->attributes['avatar'] = 'avatars/default/' . array_random(User::DEFAULT_AVATARS);
            }

            if (! isset($model->attributes['password'])) {

                $setting = new SettingKeyEnum(SettingKeyEnum::USER_INIT_PASSWORD);
                $model->attributes['password'] = bcrypt(setting($setting, '123456'));
            }

        });

        static::created(function ($model) {

            // 用户注册之后，得到注册的来源
            // 存入 redis 缓存，每日更新到统计表
            $source = UserSourceEnum::search($model->source) ?: UserSourceEnum::search(UserSourceEnum::MOON);

            $registerKey = SiteCountCacheEnum::MOON_REGISTER_COUNT;
            switch ($source) {
                case 'qq':
                    $registerKey = SiteCountCacheEnum::QQ_REGISTER_COUNT;
                    break;
                case 'weibo':
                    $registerKey = SiteCountCacheEnum::WEIBO_REGISTER_COUNT;
                    break;
                case 'github':
                    $registerKey = SiteCountCacheEnum::GITHUB_REGISTERED_COUNT;
                    break;
                default:
                    break;
            }

            Cache::increment($registerKey);
            Cache::increment(SiteCountCacheEnum::REGISTERED_COUNT);
        });
    }


    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
}
