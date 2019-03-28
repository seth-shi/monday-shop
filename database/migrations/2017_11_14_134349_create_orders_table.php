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

            $table->unsignedInteger('user_id');
            $table->decimal('total', 12, 2)->comment('总计价格');
            $table->tinyInteger('status')->default(Order::STATUSES['UN_PAY'])->comment('-2：退款，-1: 申请退款 0：未支付订单，1:支付宝支付， 2：微信 3：超时取消, 4. 完成');

            // 物流状况
            $table->string('refund_reason')->nullable()->comment('退款理由');
            $table->tinyInteger('ship_status')->default(Order::SHIP_STATUSES['PENDING'])->comment('物流状况');
            $table->string('express_company')->nullable()->comment('快递公司');
            $table->string('express_no')->nullable()->comment('快递单号');

            $table->tinyInteger('type')->default(Order::TYPES['COMMON'])->comment('订单类型,1普通订单，2秒杀订单');

            $table->string('name')->nullable()->comment('订单的名字，用于第三方，只有一个商品就是商品的名字，多个商品取联合');
            // 收货地址
            $table->string('consignee_name')->nullable()->comment('收货人');
            $table->string('consignee_phone')->nullable()->comment('收货人手机号码');
            $table->string('consignee_address')->nullable()->comment('收货地址');

            // 第三方支付
            $table->string('pay_no')->nullable()->comment('第三方支付单号');
            $table->decimal('pay_total', 12, 2)->nullable()->comment('实际支付金额');
            $table->timestamp('pay_time')->nullable()->comment('支付时间');
            $table->decimal('pay_refund_fee', 12, 2)->nullable()->comment('退款金额');
            $table->string('pay_trade_no')->nullable()->comment('第三方退款订单号');

            $table->softDeletes();

            $table->timestamps();
        });

        DB::statement("ALTER TABLE `orders` comment'订单表'");

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
