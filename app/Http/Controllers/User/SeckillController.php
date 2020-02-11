<?php

namespace App\Http\Controllers\User;

use App\Enums\OrderTypeEnum;
use App\Enums\SettingKeyEnum;
use App\Jobs\CancelUnPayOrder;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Seckill;
use App\Models\User;
use App\Utils\OrderUtil;
use Carbon\Carbon;
use Illuminate\Auth\SessionGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Jenssegers\Agent\Agent;

class SeckillController extends PaymentController
{
    protected $redisSeckill;

    public function show($id)
    {
        $seckill = new Seckill(compact('id'));
        $redisSeckill = $this->getSeckill($seckill);

        $product = $redisSeckill->product;

        /**
         * @var $user User
         * 如果登录返回所有地址列表，如果没有，则返回一个空集合
         */
        $addresses = collect();
        if ($user = auth()->user()) {

            $addresses = $user->addresses()->get();
        }

        return view('seckills.show', compact('redisSeckill', 'product', 'addresses'));
    }

    /**
     * 抢购秒杀
     *
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function storeSeckill(Request $request, $id)
    {
        /**
         * 直接从 session 中读取 id，不经过数据库
         *
         * @var $user User
         * @var $auth SessionGuard
         */
        $seckill = new Seckill(compact('id'));
        $auth = auth('web');
        $userId = session()->get($auth->getName());

        try {

            if (! $request->has('address_id')) {

                throw new \Exception('必须选择一个地址');
            }

            // 验证是否有这个秒杀
            // 验证秒杀活动是否已经结束
            $redisSeckill = $this->redisSeckill = $this->getSeckill($seckill);

            if (! $redisSeckill->is_start) {
                throw new \Exception('秒杀未开始');
            }

        } catch (\Exception $e) {

            return responseJson(402, $e->getMessage());
        }

//        // 返回 0，代表之前已经设置过了，代表已经抢过
//        if (0 == Redis::hset($seckill->getUsersKey($userId), 'id', $userId)) {
//
//            return responseJson(403, '你已经抢购过了');
//        }

        // 开始抢购逻辑,如果从队列中读取不到了，代表已经抢购完成
        if (is_null(Redis::lpop($seckill->getRedisQueueKey()))) {

            return responseJson(403, '已经抢购完了');
        }


        DB::beginTransaction();

        try {

            $product = $redisSeckill->product;
            if (is_null($product)) {
                return responseJson(400, '商品已下架');
            }

            // 已经通过抢购请求，可以查询数据库
            // 在这里验证一下地址是不是本人的
            $user = auth()->user();
            $address = Address::query()->where('user_id', $user->id)->find($request->input('address_id'));

            if (is_null($address)) {
                return responseJson(400, '无效的收货地址');
            }

            // 创建一个秒杀主表订单和明细表订单，默认数量一个
            $masterOrder = ($orderUtil = new OrderUtil([['product' => $product]]))->make($user->id, $address);
            $masterOrder->type = OrderTypeEnum::SEC_KILL;
            $masterOrder->amount = $redisSeckill->price;
            $masterOrder->save();

            // 创建订单明细
            $details = $orderUtil->getDetails();
            data_set($details, '*.order_id', $masterOrder->id);
            OrderDetail::query()->insert($details);


            // 当订单超过三十分钟未付款，自动取消订单
            $setting = new SettingKeyEnum(SettingKeyEnum::UN_PAY_CANCEL_TIME);
            $delay = Carbon::now()->addMinute(setting($setting, 30));
            CancelUnPayOrder::dispatch($masterOrder)->delay($delay);

            // 生成支付信息
            $form = $this->buildPayForm($masterOrder, (new Agent)->isMobile())->getContent();

        } catch (\Exception $e) {

            DB::rollBack();

            // 回滚一个秒杀数量
            Redis::lpush($seckill->getRedisQueueKey(), 9);
            // 把当前用户踢出，给他继续抢购
            Redis::del($seckill->getUsersKey($userId));

            return responseJson(403, $e->getMessage());
        }

        DB::commit();

        // 数量减 -
        $redisSeckill->sale_count += 1;
        $redisSeckill->number -= 1;
        Redis::set($seckill->getRedisModelKey(), json_encode($redisSeckill));
        // 存储抢购成功的用户名
        $user = auth()->user();
        Redis::hset($seckill->getUsersKey($userId), 'name', $user->hidden_name);



        return responseJson(200, '抢购成功', compact('form'));
    }

    public function getSeckillUsers($id)
    {
        $seckill = new Seckill(compact('id'));
        $keys = Redis::keys($seckill->getUsersKey('*'));

        $users = collect();
        foreach ($keys as $key) {

            $users->push(Redis::hget($key, 'name'));
        }

        return responseJson(200, 'success', $users);
    }

    /**
     * 从 redis 中获取秒杀的数据
     *
     * @param Seckill $seckill
     * @return mixed
     */
    protected function getSeckill(Seckill $seckill)
    {
        /**
         * @var $product Product
         */
        $json = Redis::get($seckill->getRedisModelKey());
        $redisSeckill = json_decode($json);

        if (is_null($redisSeckill)) {

            abort(403, "没有这个秒杀活动");
        }

        // 得到这些时间
        $now = Carbon::now();
        $endAt = Carbon::make($redisSeckill->end_at);

        if ($now->gt($endAt)) {

            abort(403, "秒杀已经结束");
        }

        // 秒杀是否已经开始
        $startAt = Carbon::make($redisSeckill->start_at);
        $redisSeckill->is_start = $now->gt($startAt);
        // 开始倒计时
        $redisSeckill->diff_time = $startAt->getTimestamp() - time();

        return $redisSeckill;
    }

    /**
     * 重写父类的构建订单明细
     *
     * @param Product $product
     * @param         $number
     * @return array
     */
    protected function buildOrderDetail(Product $product, $number)
    {
        $attribute =  [
            'product_id' => $product->id,
            'number' => $number
        ];

        // 价格为秒杀的价格, 直接从 redis 中读取
        $attribute['price'] = ceilTwoPrice($this->redisSeckill->price);
        $attribute['total'] = ceilTwoPrice($attribute['price'] * $attribute['number']);

        return $attribute;
    }
}
