<?php

use App\Jobs\InstallShopWarn;
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
        $time = date('Y-m-d H:i:s');
        $msg = '网站已启动 启动时间: ' . $time;
        // Add a task to the queue to remind the user that the queue has started
        dispatch(new InstallShopWarn($msg));
    }
}
