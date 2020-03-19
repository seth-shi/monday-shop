<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\SearchAble\ElasticSearchTrait;
use Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class AddShopToEsSearchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:shop-to-search';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '把商品添加到全文索引';

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
        try {
            ElasticSearchTrait::client()->ping([
                'client' => [
                    'timeout' => 5,
                    'connect_timeout' => 5
                ]
            ]);
        } catch (\Exception $exception) {
            
            $this->info($exception->getMessage());
            $this->info('无法连接到 elasticsearch 服务器，请配置 config/elasticsearch.php 文件');
            $this->info('默认使用 MySQL 的模糊搜索');
            $this->info('配置完毕后可运行: php artisan add:shop-to-search 添加索引');
            return;
        }
        
        
        // 新建商品索引
        if (Product::indexExists()) {
            
            Product::deleteIndex();
            $this->info('删除索引');
        }
        Product::createIndex();
        $this->info('新建索引成功');
        
        
        // 开始导入数据
        $query = Product::query();
        
        $count = $query->count();
        $handle = 0;
        
        $query->with('category')->chunk(1000, function (Collection $models) use ($count, &$handle) {
            
            $models->map(function (Product $product) use ($count, &$handle) {
                
                $product->addToIndex($product->getSearchData());
                
                ++ $handle;
                echo "\r {$handle}/$count";
            });
        });
        
        echo PHP_EOL;
        $this->info('索引生成完毕');
    }
}
