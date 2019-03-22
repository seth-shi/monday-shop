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
                'replace_text' => ':time成为注册会员。',
                'index_code' => ScoreRule::INDEX_REGISTER,
                'score' => 20,
                'times' => 0,
                'can_delete' => 0,
            ],
            [
                'replace_text' => ':time进行了登录。',
                'index_code' => ScoreRule::INDEX_LOGIN,
                'score' => 5,
                'times' => 0,
                'can_delete' => 0,
            ],
            [
                'replace_text' => '从:start_date到:end_date连续登录:days天。',
                'index_code' => ScoreRule::INDEX_CONTINUE_LOGIN,
                'score' => 20,
                'times' => 3,
                'can_delete' => 0,
            ],
            [
                'replace_text' => '从:start_date到:end_date连续登录:days天。',
                'index_code' => ScoreRule::INDEX_CONTINUE_LOGIN,
                'score' => 50,
                'times' => 7,
                'can_delete' => 1,
            ],
            [
                'replace_text' => ':date浏览了:number个商品',
                'index_code' => ScoreRule::INDEX_REVIEW_PRODUCT,
                'score' => 5,
                'times' => 10,
                'can_delete' => 0,
            ],
            [
                'replace_text' => ':time完成了订单:no',
                'description' => 'score是一个比例值, 每一元可换取多少积分',
                'index_code' => ScoreRule::INDEX_COMPLETE_ORDER,
                'score' => 1,
                'times' => 0,
                'can_delete' => 0,
            ],
        ];

        foreach ($values as $value) {

            ScoreRule::query()->create($value);
        }
    }
}
