<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['title' => '个人护理', 'thumb' => 'https://picsum.photos/seed/category-care/110/110', 'description' => '精选个人护理好物，兼顾日常清洁与舒适体验。'],
            ['title' => '运动户外', 'thumb' => 'https://picsum.photos/seed/category-sport/110/110', 'description' => '覆盖通勤健身和轻户外场景的基础装备。'],
            ['title' => '电脑办公', 'thumb' => 'https://picsum.photos/seed/category-office/110/110', 'description' => '围绕效率、桌面整洁与轻办公升级的精选单品。'],
            ['title' => '珠宝饰品', 'thumb' => 'https://picsum.photos/seed/category-jewel/110/110', 'description' => '日常可搭配的饰品与礼赠选择。'],
            ['title' => '手机数码', 'thumb' => 'https://picsum.photos/seed/category-digital/110/110', 'description' => '聚焦高频数码配件与移动设备周边。'],
            ['title' => '美食零食', 'thumb' => 'https://picsum.photos/seed/category-food/110/110', 'description' => '适合囤货、分享和下午茶时刻的人气零食。'],
            ['title' => '鲜花园艺', 'thumb' => 'https://picsum.photos/seed/category-garden/110/110', 'description' => '让生活空间更有气息的花植与园艺用品。'],
            ['title' => '品质汽车', 'thumb' => 'https://picsum.photos/seed/category-auto/110/110', 'description' => '面向爱车用户的养护、清洁与实用配件。'],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(
                ['title' => $category['title']],
                $category
            );
        }
    }
}
