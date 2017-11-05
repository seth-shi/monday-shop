<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Category::create([
            'name' => '男装',
            'pinyin' => 'nan-zhuang',
            'order_lv' => 1,
            'children' => [
                [
                    'name' => '花花公子',
                    'pinyin' => 'hua-hua-gong-zi',
                    'children' => [
                        [ 'name' => '花花女子', 'pinyin' => 'hua-hua-nv-zi'],
                    ],
                ],
            ],
        ]);

        Category::create([
            'name' => '手机数码',
            'pinyin' => 'shou-ji-shu-ma',
            'order_lv' => 2,
            'children' => [
                [
                    'name' => '智能手机',
                    'pinyin' => 'zhi-neng-gong-zi',
                    'children' => [
                        [ 'name' => 'VIVO手机','pinyin' => 'vivo-shou-ji'],
                    ],
                ],
            ],
        ]);

        Category::create(['name' => '美食零食','pinyin' => 'mei-shi-ling-shi']);
        Category::create(['name' => '鲜花园艺','pinyin' => 'xiang-hua-yuan-yi']);
        Category::create(['name' => '品质汽车','pinyin' => 'pin-zhi-qi-che']);
    }
}
