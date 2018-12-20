<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->unsignedInteger('order_id');
            $table->unsignedInteger('product_id');

            $table->integer('number')->comment('数量');
            $table->decimal('price', 12, 2)->comment('商品单价');
            $table->decimal('total', 12, 2)->comment('价格小计算');

            $table->boolean('is_commented')->default(false)->comment('订单是否评论过');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `order_details` comment'订单明细表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
