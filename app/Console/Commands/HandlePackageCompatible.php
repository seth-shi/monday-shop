<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HandlePackageCompatible extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gps:compatible';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compatibility of processing laravel5.5 packages';

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
        // etrepat/baum's fire method chang handle method
        $this->compatibleBaum();


    }


    private function compatibleBaum()
    {
        $filename = base_path("vendor\\baum\baum\\src\\Baum\\Console\\InstallCommand.php");

        if (! is_file($filename)) {
            return print "etrepat/baum packgist not exists";
        }

        if ($this->strReplaceFileContent($filename, 'fire', 'handle')) {
            print 'repleace etrepat/baum success';
        } else {
            print 'repleace etrepat/baum fail';
        }

    }


    private function strReplaceFileContent($filename, $search, $replace)
    {
        $content = file_get_contents($filename);

        $content = str_replace($search, $replace, $content);

        return file_put_contents($filename, $content);
    }


}
