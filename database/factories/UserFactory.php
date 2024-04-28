<?php

namespace Database\Factories;

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

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

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->withFaker()->name,
            'email' => $this->withFaker()->unique()->safeEmail,
            'sex' => random_int(0, 1),
            'password' => bcrypt('123456'),
            'active_token' => str_random(60),
            'is_active' => 1,
            'remember_token' => str_random(10),
        ];
    }
}
