<?php

namespace App\Models;

use App\Models\SearchAble\ElasticSearchTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Overtrue\Pinyin\Pinyin;
use Ramsey\Uuid\Uuid;


/**
 * App\Models\Product
 *
 * @method static withTrashed()
 * @property int $id
 * @property int $category_id 商品所属分类
 * @property string $uuid 商品的uuid号
 * @property string $name
 * @property string $title 简短的描述
 * @property float $price 商品的价格
 * @property float $original_price 商品原本的价格
 * @property string $thumb 商品的缩略图
 * @property array $pictures 图片的列表
 * @property int $sale_count 出售的数量
 * @property int $count 商品库存量
 * @property string|null $pinyin 商品名的拼音
 * @property string|null $first_pinyin 商品名的拼音的首字母
 * @property string|null $deleted_at 是否上架
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Car[] $cars
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read \App\Models\ProductDetail $detail
 * @property-read \App\Models\OrderDetail $orderDetail
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereFirstPinyin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePictures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePinyin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePriceOriginal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSafeCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product withoutTrashed()
 * @mixin \Eloquent
 * @property int|null $view_count
 * @property int|null $today_has_view
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereOriginalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSaleCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereTodayHasView($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereViewCount($value)
 */
class Product extends Model
{
    use SoftDeletes, ElasticSearchTrait;

    public static $addToSearch = true;

    protected $fillable = [
        'category_id', 'name', 'price', 'original_price',
        'pinyin', 'first_pinyin', 'thumb', 'uuid', 'title', 'pictures'];

    protected $casts = [
        'pictures' => 'json',
    ];



    public function getThumbAttribute($thumb)
    {
        return assertUrl($thumb);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'likes_products')->withTimestamps();
    }

    public function detail()
    {
        return $this->hasOne(ProductDetail::class);
    }


    public function orderDetail()
    {
        return $this->hasOne(orderDetail::class);
    }

    /**
     * 使用 uuid 注入
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function getViewCountAttribute()
    {
        $date = Carbon::today()->toDateString();

        return $this->attributes['view_count'] + Cache::get($this->getViewCountKey($date), 0);
    }

    public function getViewCountKey($date)
    {
        return "moon:products_cache_{$date}:view_count_{$this->id}";
    }

    public static function boot()
    {
        parent::boot();


        // 自动生成商品的 uuid， 拼音
        static::saving(function (Product $model) {

            if (is_null($model->uuid)) {
                $model->uuid = Uuid::uuid4()->toString();
            }

            if (is_null($model->pinyin)) {

                /**
                 * @var $pinyin Pinyin
                 */
                $pinyin = app(Pinyin::class);

                $model->pinyin = $pinyin->permalink($model->name);
                $model->first_pinyin = substr($model->pinyin, 0, 1);
            }


            if ($model->isDirty('first_pinyin')) {

                // 建立拼音表
                ProductPinYin::query()->firstOrCreate(['pinyin' => $model->first_pinyin]);
            }

            if (self::$addToSearch) {
                try {

                    $model->addToIndex($model->getSearchData());
                } catch (\Exception $e) {

                    dump('error');
                }
            }

        });

        static::deleted(function (Product $model) {

            // 没有这个拼音了，删去
            if (Product::query()->where('first_pinyin', $model->first_pinyin)->doesntExist()) {
                ProductPinYin::query()->where('pinyin', $model->first_pinyin)->delete();
            }

            if (self::$addToSearch) {
                try {

                    $model->removeFromIndex();
                } catch (\Exception $e) {

                }
            }
        });


        // 从软删除中恢复
        static::restored(function (Product $model) {

            // 建立拼音表
            ProductPinYin::query()->firstOrCreate(['pinyin' => $model->first_pinyin]);

            if (self::$addToSearch) {
                try {

                    $model->addToIndex($this->getSearchData());
                } catch (\Exception $e) {

                }
            }
        });
    }

    public function getSearchData()
    {
        $categoryName = $this->category->title ?? '';
        $title = $this->name . ' ' . $this->title;
        $text = str_replace(["\t", "\r", "\n"], ['', '', ''], strip_tags($this->detail->content ?? ''));

        return [
            'id' => $this->id,
            'title' => $title,
            'body' => $text . ' ' . $categoryName
        ];
    }


    public function getIndexName()
    {
        return 'product';
    }

    public function getMappingProperties()
    {
        return [
            'id' => [
                'type' => 'integer'
            ],
            'title' => [
                'type' => 'text',
                'analyzer' => 'ik_max_word',
                'search_analyzer' => 'ik_smart',
                'index' => true,
            ],
            'body' => [
                'type' => 'text',
                'analyzer' => 'ik_max_word',
                'search_analyzer' => 'ik_smart',
                'index' => true,
            ]
        ];
    }
}
