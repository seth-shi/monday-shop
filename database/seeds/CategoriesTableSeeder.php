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
                ['name' => '艾斯玛']
            ],
        ]);

        Category::create([
            'name' => '手机数码',
            'children' => [
                [
                    'name' => 'VIVO手机',
                    'children' => [
                        [ 'name' => 'vivo x6' ],
                    ],
                ],
            ],
        ]);
    }
}
