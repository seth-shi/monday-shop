<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function __construct()
    {
        if (! function_exists('ceilTwoPrice')) {

            require admin_path('helpers.php');
        }
    }

    public function run()
    {
        // 配置的填充
        // 国家
        // 城市的数据填充
        $this->call(SettingsTablesSeeder::class);
        $this->call(ProvincesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);


        // 等级数据表
        $this->call(ScoreTablesSeeder::class);

        $this->call(UsersTableSeeder::class);
        $this->call(AdminTablesSeeder::class);
        $this->call(CategoriesTableSeeder::class);

        // 商品
        $this->call(ProductsTableSeeder::class);

        // 收藏商品的
        // 购物车
        $this->call(LikesProductsTableSeeder::class);
        $this->call(CarsTableSeeder::class);

        // 秒杀数据
        $this->call(SeckillsTablesSeeder::class);
    }
}
