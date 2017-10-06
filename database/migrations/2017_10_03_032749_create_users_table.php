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
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('avatar')->nullable()->comment('用户的头像');
            $table->string('token', 32)->comment('邮箱验证的token');
            $table->tinyInteger('status')->default(0)->comment('用户是否激活');
            $table->string('nickname')->default('')->comment('第三方登录的用户名');
            $table->string('provider_name')->default('')->comment('第三方登录服务的名称');

            $table->string('acess_token', 32)->comment('用户API登录token 方便以后扩展');

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
