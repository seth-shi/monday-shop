<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_logs', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('rule_id')->nullable()->comment('积分规则的主键');
            $table->unsignedInteger('user_id')->comment('得到积分的用户');
            $table->string('description')->comment('score_rule 表的同名字段替换后的值');
            $table->integer('score')->comment('得到了多少积分');

            $table->timestamps();
        });

        DB::statement("ALTER TABLE `score_logs` comment'用户积分获取记录表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('score_logs');
    }
}
