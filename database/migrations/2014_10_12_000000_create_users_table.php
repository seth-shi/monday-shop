<?php

use App\Models\User;
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
            $table->string('name', 50)->nullable();
            $table->tinyInteger('sex')->default(\App\Enums\UserSexEnum::MAN)->commen('1为男，2为女');
            $table->string('email', 50)->nullable();
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
            $table->tinyInteger('source')->default(\App\Enums\UserSourceEnum::MOON)->comment('用户的来源');

            // 用户激活所需信息
            $table->string('active_token')->nullable()->comment('邮箱激活的token');

            $table->boolean('is_active')->default(\App\Enums\UserStatusEnum::UN_ACTIVE)->comment('用户是否激活');
            $table->boolean('is_init_name')->default(0)->comment('是否是初始用户名，是的话，可以修改用户名');
            $table->boolean('is_init_email')->default(0)->comment('是否是初始邮箱，是的话可以修改邮箱');
            $table->boolean('is_init_password')->default(0)->comment('是否是初始密码，是的话可以不用输入旧密码直接修改');

            $table->bigInteger('score_all')->default(0)->comment('用户的总积分');
            $table->bigInteger('score_now')->default(0)->comment('用户剩余的积分');
            $table->integer('login_days')->default(0)->comment('用户连续登录天数');
            $table->date('last_login_date')->nullable()->comment('上一次登录的日期,用于计算连续登录');

            $table->rememberToken()->comment('laravel中的记住我');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `users` comment'用户信息'");
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
