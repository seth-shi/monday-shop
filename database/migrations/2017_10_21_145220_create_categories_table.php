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
        $table->increments('id');
        NestedSet::columns($table);
        // Add needed columns here (f.ex: name, slug, path, etc.)
        $table->string('name');
        $table->string('description')->nullable()->comment('分类的描述');

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
