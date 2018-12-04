<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->unsignedInteger('user_id');
            $table->string('name')->comment('收货人名字');
            $table->string('phone')->comment('收货人手机号码');

            $table->string('province_id')->nullable()->comment('省份');
            $table->string('city_id')->nullable()->comment('城市');
            $table->string('detail_address')->comment('详细的收货地址');
            $table->tinyInteger('is_default')->default(0)->comment('是否是默认收货地址');


            $table->timestamps();
        });

        DB::statement("ALTER TABLE `addresses` comment'收货地址表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
