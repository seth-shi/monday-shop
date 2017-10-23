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
            'children' => [
                ['name' => '阿斯玛']
            ],
        ]);

        Category::create([
            'name' => '手机数码',

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
