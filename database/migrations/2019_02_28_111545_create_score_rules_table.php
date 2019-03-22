<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_rules', function (Blueprint $table) {
            $table->increments('id');

            $table->string('replace_text')->comment('获取积分的规则,描述文本,里面有可替换的标志量');
            $table->string('description')->nullable()->comment('这条规则的描述');
            $table->string('index_code')->comment('连续登录送的积分, 查看商品数量送积分,');
            $table->integer('score')->comment('增加多少的积分');
            $table->integer('times')->default(0)->comment('次数, 连续多少天的天数,查看商品的数量');
            $table->tinyInteger('can_delete')->default(1)->comment('是否可以删除');

            $table->timestamps();
        });

        DB::statement("ALTER TABLE `score_rules` comment'积分获取规则表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('score_rules');
    }
}
