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

            $table->increments('id');
            $table->date('date')->index();
            $table->integer('register_count')->unsigned()->default(0);
            $table->integer('github_regitster_count')->unsigned()->default(0);
            $table->integer('weibo_registered_count')->unsigned()->default(0);
            $table->integer('qq_registered_count')->unsigned()->default(0);
            $table->integer('moon_registered_count')->unsigned()->default(0)->comment('通过商城前台注册');
            $table->tinyInteger('product_sale_count')->unsigned()->default(0)->comment('商城商品销售的数量');
            $table->tinyInteger('product_sale_money_count')->unsigned()->default(0)->comment('商城金钱销售的数量');


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
