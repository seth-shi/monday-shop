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
        // 统计基础配置,不可删除
        $this->call(SimpleCountsTableSeeder::class);

        // 国家
        // 城市的数据填充
        $this->call(ProvincesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);

        $this->call(UsersTableSeeder::class);
        $this->call(AdminTablesSeeder::class);
        $this->call(CategoriesTableSeeder::class);

        // 商品
        $this->call(ProductsTableSeeder::class);

        // 收藏商品的
        // 购物车
        $this->call(LikesProductsTableSeeder::class);
        $this->call(CarsTableSeeder::class);

        // 生成一些订单数据
        $this->call(OrdersSeeder::class);
    }
}
