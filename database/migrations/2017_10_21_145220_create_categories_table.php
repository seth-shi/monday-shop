<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

class CreateCategoriesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {

    Schema::create('categories', function(Blueprint $table) {
        $table->engine = 'InnoDB';
        $table->increments('id');

        $table->string('title')->unique();
        $table->string('icon')->nullable()->comment('分类的图标');
        $table->string('thumb')->comment('分类的缩略图');
        $table->string('description')->nullable()->comment('分类的描述');
        $table->unsignedInteger('parent_id')->default(0)->comment('兼容插件的字段');
        $table->tinyInteger('order')->comment('排序字段')->default(9);

        $table->timestamps();
    });


      DB::statement("ALTER TABLE `categories` comment'商品分类表'");

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::drop('categories');
  }

}
