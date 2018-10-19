<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('no')->comment('订单流水号');
            $table->integer('user_id')->unsigned();
            $table->decimal('total', 15, 2)->comment('总计价格');
            $table->tinyInteger('status')->default(0)->comment('0：未支付订单，已支付订单');

            $table->text('address')->comment('收货地址');

            // 第三方支付
            $table->string('pay_no')->nullable()->comment('第三方支付单号');
            $table->timestamp('pay_time')->comment('支付时间');
            $table->tinyInteger('pay_type')->default(0)->comment('0 未知，1支付宝支付，2微信支付');


            $table->softDeletes();

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
        Schema::dropIfExists('orders');
    }
}
