<?php

namespace App\Console\Commands;


use Illuminate\Support\Facades\Storage;

class DeleteFile extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gps:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all upload static resources';

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
        Storage::deleteDirectory('public' . DIRECTORY_SEPARATOR . config('web.upload.list'));
        Storage::deleteDirectory('public' . DIRECTORY_SEPARATOR . config('web.upload.detail'));

        $this->info('delete file success');
    }
}
