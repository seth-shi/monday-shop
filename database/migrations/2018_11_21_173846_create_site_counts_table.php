<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_counts', function (Blueprint $table) {
            $table->increments('id');

            $table->date('date')->index();
            $table->unsignedInteger('registered_count')->default(0);
            $table->unsignedInteger('github_registered_count')->default(0);
            $table->unsignedInteger('weibo_registered_count')->default(0);
            $table->unsignedInteger('qq_registered_count')->default(0);
            $table->unsignedInteger('moon_registered_count')->default(0)->comment('通过商城前台注册');
            $table->unsignedInteger('product_sale_count')->default(0)->comment('订单成交量');
            $table->unsignedInteger('product_sale_number_count')->default(0)->comment('订单销售商品数量');
            $table->decimal('product_sale_money_count', 12, 2)->default(0)->comment('商城金钱销售的数量');

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
        Schema::dropIfExists('site_counts');
    }
}
