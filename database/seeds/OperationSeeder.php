<?php

use App\Entities\Operation;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class OperationSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        //// 清空資料表 ////
        Operation::truncate();
        //// 建立假資料 ////
        $operation = [
            'login', 'forgetpassword',
            'register', 'get-members-list', 'get-member-detail', 'update-member-detail', 'delete-member',
            'post-article', 'get-article-list', 'get-article-detail', 'update-article-detail', 'delete-article'
        ];
        $operationZh = [
            '登入', '忘記密碼',
            '註冊', '獲取會員列表', '獲取會員詳細資訊', '修改會員詳細資料', '刪除會員',
            '新增文章', '獲取文章列表', '獲取文章詳細資訊', '更新文章詳細資料', '刪除文章'
        ];
        for ($i = 0; $i < sizeof($operation); $i++) {
            Operation::create([
                'api_url' => $operation[$i],
                'function_zh' => $operationZh[$i],
                'is_active' => true,
            ]);
        }
    }
}