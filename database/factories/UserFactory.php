<?php

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

$factory->define(\App\Models\User::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'sex' => random_int(0, 1),
        'password' => bcrypt('123456'),
        'avatar' => $faker->imageUrl(120, 120),
        'active_token' => str_random(60),
        'is_active' => 1,
        'remember_token' => str_random(10),
    ];
});
