<?php

use App\Models\Level;
use App\Models\ScoreRule;
use Illuminate\Database\Seeder;

class ScoreTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $levelModels = [
            [
                'name' => '心心会员',
                'icon' => 'images/vip1.png',
                'level' => 1,
                'min_score' => 0,
                'can_delete' => 0,
            ],
            [
                'name' => '会员',
                'icon' => 'images/vip2.png',
                'level' => 2,
                'min_score' => 99,
                'can_delete' => 1,
            ]
        ];
        foreach ($levelModels as $model) {
            Level::query()->create($model);
        }


        $values = [
            [
                'description' => '会员 %username% 在 %time% 成为注册会员。',
                'index_code' => ScoreRule::INDEX_REGISTER,
                'score' => 20,
                'max_times' => 0,
                'can_delete' => 0,
            ],
            [
                'description' => '会员 %username% 在 %time% 进行了登录。',
                'index_code' => ScoreRule::INDEX_LOGIN,
                'score' => 5,
                'max_times' => 0,
                'can_delete' => 0,
            ],
            [
                'description' => '会员 %username% 从 %start_date% 到 %end_date% 连续登录%days%天。',
                'index_code' => ScoreRule::INDEX_CONTINUE_LOGIN,
                'score' => 20,
                'max_times' => 3,
                'can_delete' => 0,
            ],
            [
                'description' => '会员 %username% 从 %start_date% 到 %end_date% 连续登录%days%天。',
                'index_code' => ScoreRule::INDEX_CONTINUE_LOGIN,
                'score' => 50,
                'max_times' => 7,
                'can_delete' => 1,
            ],
            [
                'description' => '会员 %username% 在 %date% 查看了%times%个商品',
                'index_code' => ScoreRule::INDEX_REVIEW_PRODUCT,
                'score' => 5,
                'max_times' => 10,
                'can_delete' => 0,
            ],
        ];

        foreach ($values as $value) {

            ScoreRule::query()->create($value);
        }
    }
}
