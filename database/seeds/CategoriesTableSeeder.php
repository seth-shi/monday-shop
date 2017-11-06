<?php

use App\Models\Category;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        Category::create([
            'name' => '男装',
            'thumb' => $faker->imageUrl(110, 110),
            'description' => $faker->text(50),
            'order_lv' => 1,
            'children' => [
                [
                    'name' => '花花公子',
                    'thumb' => $faker->imageUrl(110, 110),
                    'description' => $faker->text(50),
                    'children' => [
                        [ 'name' => '花花女子', 'description' => $faker->text(50), 'thumb' => $faker->imageUrl(110, 110)],
                    ],
                ],
            ],
        ]);

        Category::create([
            'name' => '手机数码',
            'thumb' => $faker->imageUrl(110, 110),
            'description' => $faker->text(50),
            'order_lv' => 2,
            'children' => [
                [
                    'name' => '智能手机',
                    'thumb' => $faker->imageUrl(110, 110),
                    'description' => $faker->text(50),
                    'children' => [
                        [ 'name' => 'VIVO手机', 'description' => $faker->text(50), 'thumb' => $faker->imageUrl(110, 110)],
                    ],
                ],
            ],
        ]);

        Category::create(['name' => '美食零食', 'description' => $faker->text(50), 'thumb' => $faker->imageUrl(110, 110)]);
        Category::create(['name' => '鲜花园艺', 'description' => $faker->text(50), 'thumb' => $faker->imageUrl(110, 110)]);
        Category::create(['name' => '品质汽车',  'description' => $faker->text(50),'thumb' => $faker->imageUrl(110, 110)]);
    }
}
