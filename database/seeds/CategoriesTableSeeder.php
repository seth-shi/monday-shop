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

        Category::create([
            'name' => '男装',
            'order_lv' => 1,
            'children' => [
                [
                    'name' => '花花公子',
                    'children' => [
                        [ 'name' => '花花女子' ],
                    ],
                ],
            ],
        ]);

        Category::create([
            'name' => '手机数码',
            'order_lv' => 2,
            'children' => [
                [
                    'name' => '智能手机',
                    'children' => [
                        [ 'name' => 'VIVO手机' ],
                    ],
                ],
            ],
        ]);

        Category::create(['name' => '美食零食',]);
        Category::create(['name' => '鲜花园艺',]);
        Category::create(['name' => '品质汽车',]);
    }
}
