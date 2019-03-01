<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->comment('等级的名字');
            $table->integer('level')->comment('等级');
            $table->string('icon')->nullable()->comment('等级的图标');
            $table->bigInteger('min_score')->comment('阶级分的下限');
            $table->tinyInteger('can_delete')->default(1)->comment('是否可以删除');

            $table->timestamps();
        });

        DB::statement("ALTER TABLE `levels` comment'用户积分等级表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('levels');
    }
}
