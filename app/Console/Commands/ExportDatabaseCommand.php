<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ExportDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '导出数据到 json 文件';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::query()
                     ->oldest()
                     ->get()
                     ->transform(function (User $user) {

                         // 先排除自身主键
                         $user->offsetUnset($user->getKeyName());

                         return $user;
                     });

        file_put_contents(\UsersTableSeeder::DATA_PATH, $users->toJson(JSON_UNESCAPED_UNICODE));
    }
}
