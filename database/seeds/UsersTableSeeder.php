<?php

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    const DATA_PATH = __DIR__ . '/../data/users.json';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(self::DATA_PATH), true);


        collect($data)->map(function ($userData) {

            User::query()->create($userData);
        });

    }
}
