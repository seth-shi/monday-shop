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
    $price = mt_rand(100, 10000);
    $override = mt_rand(12, 18) / 10;

    return [
        'uuid' => Uuid::generate()->hex,
        'name' => $faker->unique()->company,
        'title' => $faker->catchPhrase,
        'price' => $price,
        'price_original' => $price * $override,
        'thumb' => $faker->imageUrl(800, 600),
        // random by category select one data
        'category_id' => \App\Models\Category::inRandomOrder()->first()->id
    ];
});
