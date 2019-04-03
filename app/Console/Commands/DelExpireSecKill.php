<?php

namespace App\Console\Commands;

use App\Models\Seckill;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class DelExpireSecKill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:del-seckills';

    /**
     * 删除过期的秒杀
     *
     * @var string
     */
    protected $description = 'delete expire seckills';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $rollbacks = collect();

        // 查出已经过期确没有回滚过的秒杀，
        Seckill::query()
               ->where('is_rollback', 0)
               ->where('end_at', '<', Carbon::now()->toDateTimeString())
               ->get()
               ->map(function (Seckill $seckill) use ($rollbacks) {

                   // 1. 回滚数量到商品
                   // 2. 设置为过期
                   $product = $seckill->product()->first();


                   // 获取 redis 数量
                   $jsonSeckill = Redis::get($seckill->getRedisModelKey());
                   $redisSeckill = json_decode($jsonSeckill, true);
                   // 获取剩余秒杀量
                   $surplus = Redis::llen($seckill->getRedisQueueKey());

                   // 恢复剩余的库存量
                   // 恢复库存数量
                   if ($redisSeckill['sale_count'] != 0) {
                       $product->increment('sale_count', $redisSeckill['sale_count']);
                   }

                   if ($surplus != 0) {
                       $product->increment('count', $surplus);
                   }


                   // 同步 redis 数据到数据库中
                   $seckill->sale_count += $redisSeckill['sale_count'];
                   $seckill->rollback_count += $surplus;
                   $seckill->is_rollback = 1;
                   $seckill->save();

                   $rollbacks->push($seckill);

                   // 删除掉秒杀数据
                   $ids = Redis::connection()->keys("seckills:{$seckill->id}:*");
                   Redis::del($ids);
               });

        if ($rollbacks->isNotEmpty()) {

            createSystemLog('系统回滚秒杀数据', $rollbacks->toArray());
        }
    }
}
