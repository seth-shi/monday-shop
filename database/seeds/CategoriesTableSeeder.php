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


        Category::create(['title' => '个人护理', 'thumb' => $faker->imageUrl(110, 110), 'description' => $faker->text(50)]);
        Category::create(['title' => '运动户外', 'thumb' => $faker->imageUrl(110, 110), 'description' => $faker->text(50)]);
        Category::create(['title' => '电脑办公', 'thumb' => $faker->imageUrl(110, 110), 'description' => $faker->text(50)]);
        Category::create(['title' => '珠宝饰品', 'thumb' => $faker->imageUrl(110, 110), 'description' => $faker->text(50)]);
        Category::create(['title' => '手机数码', 'thumb' => $faker->imageUrl(110, 110), 'description' => $faker->text(50)]);
        Category::create(['title' => '美食零食', 'description' => $faker->text(50), 'thumb' => $faker->imageUrl(110, 110)]);
        Category::create(['title' => '鲜花园艺', 'description' => $faker->text(50), 'thumb' => $faker->imageUrl(110, 110)]);
        Category::create(['title' => '品质汽车',  'description' => $faker->text(50),'thumb' => $faker->imageUrl(110, 110)]);
    }
}
