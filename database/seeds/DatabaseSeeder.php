<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
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

        // 国家
        // 城市的数据填充
        $this->call(ProvincesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
    }
}
