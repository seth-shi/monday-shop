<?php

use App\Jobs\InstallShopWarn;
use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'waitmoonman',
            'email' => '1033404553@qq.com',
            'password' => bcrypt('123456'),
            'avatar' => 'https://avatars2.githubusercontent.com/u/28035971',
            'active_token' => str_random(60),
            'is_active' => 1,
            'remember_token' => str_random(10),
        ]);
        factory(Address::class, 1)->create(['user_id' => $user->id, 'is_default' => 1]);
        factory(Address::class, 3)->create(['user_id' => $user->id]);

        // Add a task to the queue to remind the user that the queue has started
        dispatch(new InstallShopWarn($user));
    }
}
