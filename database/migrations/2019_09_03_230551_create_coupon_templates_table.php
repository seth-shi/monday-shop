<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_templates', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title')->comment('优惠券标题');
            $table->decimal('amount')->comment('满减金额');
            $table->decimal('full_amount')->comment('门槛金额');

            $table->unsignedInteger('score')->default(0)->comment('使用多少积分兑换优惠券');
            $table->date('start_date')->comment('开始日期');
            $table->date('end_date')->comment('结束日期');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_templates');
    }
}
