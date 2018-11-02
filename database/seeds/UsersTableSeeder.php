<?php

use App\Models\Address;
use App\Models\User;
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
        $firstUser = factory(User::class)->create(['email' => 'david@qq.com', 'name' => 'david']);

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
