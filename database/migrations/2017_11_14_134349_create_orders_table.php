<?php

use App\Models\Order;
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
            $table->tinyInteger('status')->default(Order::UN_PAY_STATUS)->comment('0：未支付订单，1已支付订单');

            $table->string('name')->nullable()->comment('订单的名字，用于第三方，只有一个商品就是商品的名字，多个商品取联合');
            // 收货地址
            $table->string('consignee_name')->nullable()->comment('收货人');
            $table->string('consignee_phone')->nullable()->comment('收货人手机号码');
            $table->string('consignee_address')->nullable()->comment('收货地址');

            // 第三方支付
            $table->string('pay_no')->nullable()->comment('第三方支付单号');
            $table->decimal('pay_total', 15, 2)->nullable()->comment('实际支付金额');
            $table->timestamp('pay_time')->nullable()->comment('支付时间');
            $table->tinyInteger('pay_type')->default(Order::UN_PAY_TYPE)->comment('0 未知，1支付宝支付，2微信支付');


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
