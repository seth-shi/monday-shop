<?php

namespace App\Console\Commands;


use Illuminate\Support\Facades\Storage;

class CopyFile extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gps:copy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy all upload static resources';

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
     * 把静态资源发布到 public/storage 目录
     *
     * @return mixed
     */
    public function handle()
    {

        $to = 'public' . DIRECTORY_SEPARATOR . config('web.upload.list');
        $files = Storage::files('resources/products');
        Storage::makeDirectory($to);

        foreach ($files as $file) {
            $filename = $to . DIRECTORY_SEPARATOR . basename($file);
            Storage::copy($file, $filename);
        }


        $this->info('copy file success');
    }
}
