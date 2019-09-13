<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_codes', function (Blueprint $table) {
            $table->increments('id');

            $table->char('code', 16)->comment('兑换码');
            $table->unsignedInteger('user_id')->comment('发放给哪一个用户');
            $table->unsignedInteger('template_id')->comment('兑换码模板');
            $table->timestamp('used_at')->nullable()->comment('兑换码是否已经使用');
            $table->timestamp('notification_at')->nullable()->comment('通知时间');

            $table->timestamps();
        });


        DB::statement("ALTER TABLE `coupon_codes` comment'优惠券兑换码表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_codes');
    }
}
