<?php

namespace Database\Factories;


use App\Models\Address;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
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
class AddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->withFaker()->name,
            'phone' => $this->withFaker()->phoneNumber,
            'province_id' => DB::table('provinces')->inRandomOrder()->first()->id,
            'city_id' => DB::table('cities')->inRandomOrder()->first()->id,
            'detail_address' => $this->withFaker()->address,
        ];
    }
}
