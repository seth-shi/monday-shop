<?php

use App\Models\Address;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

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

$factory->define(Address::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'province_id' => DB::table('provinces')->inRandomOrder()->first()->id,
        'city_id' => DB::table('cities')->inRandomOrder()->first()->id,
        'detail_address' => $faker->address,
    ];
});
