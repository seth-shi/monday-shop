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
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('uuid')->comment('商品的uuid号');
            $table->string('name')->unique();
            $table->string('title')->comment('简短的描述');
            $table->decimal('price', 10, 2)->comment('商品的价格');
            $table->decimal('price_original', 10, 2)->comment('商品原本的价格');
            $table->string('thumb')->comment('商品的缩略图');

            $table->integer('safe_count')->default(0)->comment('出售的数量');
            $table->tinyInteger('is_hot')->default(0)->comment('是否热卖商品');
            $table->tinyInteger('is_alive')->default(1)->comment('是否上架');

            $table->string('pinyin')->nullable()->comment('商品名的拼音');
            $table->char('first_pinyin', 1)->nullable()->comment('商品名的拼音的首字母');

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
