<?php

namespace App\Console\Commands;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class CopyFile extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:copy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy all upload static resources';

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        parent::__construct();
    }

    /**
     * 把静态资源发布到 public/storage 目录
     *
     * @return mixed
     */
    public function handle()
    {
        // 图片的静态目录
        $from = storage_path('app/resources/products');
        $to = storage_path('app/public/products');
        $this->filesystem->copyDirectory($from, $to);

        // 默认头像
        $from = storage_path('app/resources/avatars');
        $to = storage_path('app/public/avatars');
        $this->filesystem->copyDirectory($from, $to);

        // 默认头像
        $from = storage_path('app/resources/images');
        $to = storage_path('app/public/images');
        $this->filesystem->copyDirectory($from, $to);

        $this->info('copy file success');
    }
}
