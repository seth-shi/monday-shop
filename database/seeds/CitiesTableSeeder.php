<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = file_get_contents(__DIR__ . '/../data/cities.json');
        $data = json_decode($data, true);

        DB::table('cities')->insert($data);
    }
}
