<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeckillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seckills', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('category_id');
            $table->unsignedInteger('product_id');

            $table->decimal('price', 12, 2)->comment('秒杀价');
            $table->unsignedInteger('number')->default(1)->comment('秒杀的数量');
            $table->unsignedInteger('rollback_count')->default(0)->comment('回滚的库存量');
            $table->unsignedInteger('sale_count')->default(0)->comment('卖出的数量');

            $table->dateTime('start_at')->comment('抢购开始时间');
            $table->dateTime('end_at')->comment('抢购结束时间');

            // 回滚过了，就不继续回滚
            $table->tinyInteger('is_rollback')->default(0)->comment('是否回滚了数量');

            $table->timestamps();
        });

        DB::statement("ALTER TABLE `seckills` comment'秒杀表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seckills');
    }
}
