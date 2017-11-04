<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gps:base';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'don`t use';

    public function __construct()
    {
        parent::__construct();
    }


    public function execShellWithPrint($command)
    {

        $this->info('----------');
        $this->info($command);

        $output = shell_exec($command);

        $this->info($output);
    }

}
