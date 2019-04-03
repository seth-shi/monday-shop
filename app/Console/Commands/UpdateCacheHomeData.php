<?php

namespace App\Console\Commands;

use App\Enums\HomeCacheEnum;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class UpdateCacheHomeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:update-home';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $categories = Category::query()->withCount('products')->orderBy('order')->take(9)->get();
        $hotProducts = Product::query()->withCount('users')->orderBy('sale_count', 'desc')->take(3)->get();
        $latestProducts = Product::query()->withCount('users')->latest()->take(9)->get();
        $users = User::query()->orderBy('login_count', 'desc')->take(10)->get(['avatar', 'name']);

        // 更换成枚举
        Cache::forever(HomeCacheEnum::CATEGORIES, $categories);
        Cache::forever(HomeCacheEnum::HOTTEST, $hotProducts);
        Cache::forever(HomeCacheEnum::LATEST, $latestProducts);
        Cache::forever(HomeCacheEnum::USERS, $users);
    }
}
