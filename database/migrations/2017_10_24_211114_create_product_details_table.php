<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->longText('content')->comment('商品的描述');

            $table->unsignedInteger('product_id');

            $table->timestamps();
        });

        DB::statement("ALTER TABLE `product_details` comment'商品明细表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_details');
    }
}
