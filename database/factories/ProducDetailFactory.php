<?php

use App\Models\ProductDetail;
use Faker\Generator as Faker;

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

$factory->define(ProductDetail::class, function (Faker $faker) {

    return [
        'count' => mt_rand(100, 1000),
        'unit' => '件',
        'description' => $faker->text(),
    ];
});
