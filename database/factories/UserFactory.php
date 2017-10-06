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
    static $password;

    return [
        'username' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => md5('123456'),
        'acess_token' => str_random(32),
        'token' => str_random(32),
        'avatar' => $faker->imageUrl($width = 120, $height = 120),

        'created_at' => time(),
        'updated_at' => time(),
    ];
});
