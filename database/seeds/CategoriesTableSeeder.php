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
            'order_lv' => 2,
            'children' => [
                ['name' => '阿斯玛', 'order_lv' => 4]
            ],
        ]);

        Category::create([
            'name' => '手机数码',
            'order_lv' => 1,
            'children' => [
                [
                    'name' => 'VIVO',
                    'children' => [
                        [ 'name' => 'vivo 系列' ],
                    ],
                ],
            ],
        ]);
    }
}
