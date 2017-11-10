<?php

use App\Models\Address;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User::class, 10)->create()->each(function ($u) {

            // default select address
            factory(Address::class, 1)->create(['user_id' => $u->id, 'is_default' => 1]);
            $count = mt_rand(1, 2);
            factory(Address::class, $count)->create(['user_id' => $u->id]);
        });
    }
}
