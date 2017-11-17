<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 50)->unique();
            $table->tinyInteger('sex')->default(1)->commen('1为男，0为女');
            $table->string('email', 50);
            $table->string('password', 60);

            // 用户信息
            $table->string('avatar')->comment('用户的头像');

            // 第三方登录
            $table->integer('github_id')->nullable()->index()->comment('github第三方登录的ID');
            $table->string('github_name')->nullable()->comment('github第三方登录的用户名');
            $table->string('qq_id')->nullable()->index();
            $table->string('qq_name')->nullable();
            $table->string('weibo_id')->nullable()->index();
            $table->string('weibo_name')->nullable();


            $table->integer('login_count')->default(0)->comment('登录次数');

            // 用户激活所需信息
            $table->string('active_token')->comment('邮箱激活的token');
            $table->tinyInteger('is_active')->default(0)->comment('用户是否激活');

            $table->rememberToken()->comment('laravel中的记住我');
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
        Schema::dropIfExists('users');
    }
}
