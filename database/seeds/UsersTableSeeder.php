<?php

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    const DATA_PATH = __DIR__ . '/data/users.json';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(self::DATA_PATH), true);


        collect($data)->map(function ($userData) {



        });

        /**
         * @var $users \Illuminate\Database\Eloquent\Collection
         */
        $users = factory(User::class, 10)->create();

        $users->put(null, $firstUser)->each(function ($u) {

            // default select address
            factory(Address::class, 1)->create(['user_id' => $u->id, 'is_default' => 1]);
            $count = mt_rand(1, 2);
            factory(Address::class, $count)->create(['user_id' => $u->id]);
        });
    }
}
