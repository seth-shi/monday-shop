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
  public function up() {
    Schema::create('categories', function(Blueprint $table) {
        $table->engine = 'InnoDB';
        $table->increments('id');
        NestedSet::columns($table);
        // Add needed columns here (f.ex: name, slug, path, etc.)
        $table->string('name')->unique();
        $table->string('thumb');
        $table->string('description')->nullable()->comment('分类的描述');
        $table->tinyInteger('order_lv')->default(1);

        $table->timestamps();
    });
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
