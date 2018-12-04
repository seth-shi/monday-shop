<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPinYinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_pin_yins', function (Blueprint $table) {
            $table->increments('id');

            $table->char('pinyin', 1);

            $table->timestamps();
        });

        DB::statement("ALTER TABLE `product_pin_yins` comment'商品拼音表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_pin_yins');
    }
}
