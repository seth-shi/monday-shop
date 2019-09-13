<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_notifications', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->text('content')->nullable()->comment('内容通知');

            $table->timestamps();
        });

        DB::statement("ALTER TABLE `article_notifications` comment '通知文章表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_notifications');
    }
}
