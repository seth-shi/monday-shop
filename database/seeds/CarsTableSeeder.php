<?php

use App\Models\Cars;
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
        $cars = factory(Cars::class, 100)->make();

        Cars::insert($cars->toArray());
    }
}
