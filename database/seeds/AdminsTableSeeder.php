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
                'email' => '1033404553@qq.com',
                'avatar' => $faker->imageUrl(120, 120)
        ]);

        Admin::create([
            'name' => 'guest',
            'password' => bcrypt('guest'),
            'email' => $faker->email,
            'avatar' => $faker->imageUrl(120, 120)
        ]);
    }
}
