<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->comment('商品的uuid号');
            $table->string('name')->unique();
            $table->decimal('price', 8, 2)->comment('商品的价格');
            $table->decimal('price_original', 8, 2)->comment('商品原本的价格');
            $table->string('thumb')->comment('商品的缩略图');

            $table->integer('likes')->default(0)->comment('收藏此商品人的数量');
            $table->integer('safe_count')->default(0)->comment('出售的数量');
            $table->tinyInteger('is_hot')->default(0)->comment('是否热卖商品');
            $table->tinyInteger('is_alive')->default(1)->comment('是否上架');

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');

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
        Schema::dropIfExists('products');
    }
}
