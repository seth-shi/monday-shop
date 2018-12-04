<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('order_id');
            $table->unsignedInteger('order_detail_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('user_id');

            $table->text('content')->comment('评论内容');
            $table->tinyInteger('score')->default(5)->commnet('评分');

            $table->timestamps();
        });

        DB::statement("ALTER TABLE `comments` comment'评论表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
