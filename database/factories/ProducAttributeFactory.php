<?php

use App\Models\ProductAttribute;
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

$factory->define(ProductAttribute::class, function (Faker $faker) {

    return [
        'attribute' => '颜色',
        'items' => $faker->colorName,
        'markup' => mt_rand(10, 20),
    ];
});
