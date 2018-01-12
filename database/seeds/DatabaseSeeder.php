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
        $this->call(AdminsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);

        $this->call(ProductsTableSeeder::class);
        $this->call(JobsTableSeeder::class);

        // permission and roles
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        // Assign role permissions
        $this->call(PermissionsRolesTableSeeder::class);


        $this->call(LikesProductsTableSeeder::class);
        $this->call(CarsTableSeeder::class);

        // Provincial and municipal regions
        $this->call(ProvincesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);

        // 管理员拥有的角色
        $this->call(AdminsRoleTableSeeder::class);
    }
}
