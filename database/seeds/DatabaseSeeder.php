<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
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

        // 国家
        // 城市的数据填充
        $this->call(ProvincesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
    }
}
