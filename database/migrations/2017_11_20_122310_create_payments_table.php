<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');

            $table->decimal('price', 10, 2)->comment('订单的价格');
            $table->tinyInteger('istype')->comment('1：支付宝；2：微信支付');
            $table->string('orderid')->comment('必填。我们会据此判别是同一笔订单还是新订单。我们回调时，会带上这个参数。例：201710192541');
            $table->string('orderuid')->comment('选填。我们会显示在您后台的订单列表中，方便您看到是哪个用户的付款，方便后台对账。强烈建议填写。可以填用户名，也可以填您数据库中的用户uid。');
            $table->string('goodsname')->comment('商品名字');

            // notify field
            $table->string('paysapi_id')->nullable()->comment('一定存在。一个24位字符串，是此订单在PaysApi服务器上的唯一编号');
            $table->decimal('realprice', 10, 2)->nullable()->comment('实际支付的钱');

            $table->tinyInteger('status')->default(0)->comment('0 未支付，1：支付');

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
        Schema::dropIfExists('payments');
    }
}
