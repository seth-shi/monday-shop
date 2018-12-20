<?php

use App\Models\Car;
use App\Models\Product;
use App\Models\User;
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

$factory->define(Car::class, function (Faker $faker) {

    return [
        'user_id' => User::inRandomOrder()->first()->id,
        'product_id' => Product::inRandomOrder()->first()->id,
        'number' => mt_rand(1, 5),
        'created_at' => time(),
        'updated_at' => time()
    ];
});
