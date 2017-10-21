<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(
            ['name' => '手机数码']
        );

        Category::create(
            ['name' => '男装']
        );

        Category::create(
            ['name' => '家居']
        );

        Category::create(
            ['name' => '箱包']
        );
    }
}
