<?php

use Faker\Generator as Faker;
use Webpatser\Uuid\Uuid;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


$factory->define(\App\Models\Product::class, function (Faker $faker) {
    $name = $faker->unique()->company;
    $price = mt_rand(100, 10000);
    $price_original = $price * (mt_rand(12, 18) / 10);
    $pinyin = pinyin_permalink($name);
    $first_pinyin = substr($pinyin, 0, 1);

    return [
        'uuid' => Uuid::generate()->hex,
        'name' => $name,
        'title' => $faker->catchPhrase,
        'price' => $price,
        'price_original' => $price_original,
        'thumb' => $faker->imageUrl(800, 600),

        'pinyin' => $pinyin,
        'first_pinyin' => $first_pinyin,

        // random by category select one data
        'category_id' => \App\Models\Category::inRandomOrder()->first()->id
    ];
});
