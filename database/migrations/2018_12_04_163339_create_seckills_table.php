<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeckillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seckills', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('product_id');
            $table->unsignedInteger('numbers')->default(1);
            $table->dateTime('start_at')->comment('抢购开始时间');
            $table->dateTime('end_at')->comment('抢购结束时间');

            $table->timestamps();
        });

        DB::statement("ALTER TABLE `seckills` comment'秒杀表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seckills');
    }
}
