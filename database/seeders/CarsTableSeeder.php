<?php

namespace Database\Seeders;


use Database\Factories\CarsFactory;
use Illuminate\Database\Seeder;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CarsFactory::times(100)->create();
    }
}
