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

            $table->unsignedInteger('category_id')->comment('商品所属分类');
            $table->string('uuid')->comment('商品的uuid号');
            $table->string('name')->unique();
            $table->string('title')->comment('简短的描述');
            $table->decimal('price', 12, 2)->comment('商品的价格');
            $table->decimal('original_price', 12, 2)->comment('商品原本的价格');
            $table->string('thumb')->comment('商品的缩略图');
            $table->text('pictures')->comment('图片的列表');

            $table->unsignedInteger('view_count')->default(0)->comment('商品的浏览次数');
            $table->tinyInteger('today_has_view')->default(0)->comment('今日是否有浏览量');

            $table->integer('sale_count')->default(0)->comment('出售的数量');
            $table->integer('count')->comment('商品库存量');


            $table->string('pinyin')->nullable()->comment('商品名的拼音');
            $table->char('first_pinyin', 1)->nullable()->comment('商品名的拼音的首字母');



            $table->softDeletes()->comment('是否上架');

            $table->index('uuid');

            $table->timestamps();
        });

        DB::statement("ALTER TABLE `products` comment'商品表'");

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
