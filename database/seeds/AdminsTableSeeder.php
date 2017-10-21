<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        Admin::create([
                'name' => 'admin',
                'password' => bcrypt('admin'),
                'avatar' => $faker->imageUrl(120, 120)
        ]);

        Admin::create([
            'name' => 'guest',
            'password' => bcrypt('guest'),
            'avatar' => $faker->imageUrl(120, 120)
        ]);
    }
}
