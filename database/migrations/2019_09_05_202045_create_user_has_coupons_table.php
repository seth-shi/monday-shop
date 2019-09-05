<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserHasCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_has_coupons', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id')->comment('领取的用户');
            $table->unsignedInteger('template_id');
            $table->string('title')->comment('优惠券标题');
            $table->decimal('amount')->comment('满减金额');
            $table->decimal('full_amount')->comment('门槛金额');
            $table->date('start_date')->comment('开始日期');
            $table->date('end_date')->comment('结束日期');

            $table->timestamp('used_at')->nullable()->comment('使用时间');

            $table->timestamps();
        });

        DB::statement("ALTER TABLE `user_has_coupons` comment'用户拥有的优惠券表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_has_coupons');
    }
}
