<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes_products', function (Blueprint $table) {

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('product_id');

            $table->timestamps();

            $table->primary(['user_id', 'product_id']);
        });

        DB::statement("ALTER TABLE `likes_products` comment'用户收藏的商品关联表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes_products');
    }
}
