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

            $table->string('name')->comment('收货人名字');
            $table->string('phone')->comment('收货人手机号码');

            $table->string('province')->nullable()->comment('省份');
            $table->string('city')->nullable()->comment('城市');
            $table->string('detail_address')->comment('详细的收货地址');
            $table->tinyInteger('is_default')->default(0)->comment('是否是默认收货地址');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('addresses');
    }
}
