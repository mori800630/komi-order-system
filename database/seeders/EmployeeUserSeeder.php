<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeUserSeeder extends Seeder
{
    public function run(): void
    {
        // 既存のユーザーを削除
        User::truncate();

        // 部門を取得
        $westernDept = Department::where('name', '洋菓子製造部')->first();
        $sandwichDept = Department::where('name', 'サンドイッチ製造部')->first();
        $breadDept = Department::where('name', 'パン製造部')->first();
        $cheesecakeMainDept = Department::where('name', 'チーズケーキ製造部(本店)')->first();
        $cheesecakeNangokuDept = Department::where('name', 'チーズケーキ製造部(南国店)')->first();

        // 社員データ
        $employees = [
            // システム管理者
            [
                'name' => '田中 正義',
                'email' => 'tanaka.masayoshi@komi-bakery.com',
                'role' => 'admin',
                'department_id' => null,
            ],
            
            // 店舗スタッフ
            [
                'name' => '佐藤 美咲',
                'email' => 'sato.misaki@komi-bakery.com',
                'role' => 'store',
                'department_id' => null,
            ],
            [
                'name' => '鈴木 健太',
                'email' => 'suzuki.kenta@komi-bakery.com',
                'role' => 'store',
                'department_id' => null,
            ],
            [
                'name' => '高橋 愛子',
                'email' => 'takahashi.aiko@komi-bakery.com',
                'role' => 'store',
                'department_id' => null,
            ],
            [
                'name' => '渡辺 大輔',
                'email' => 'watanabe.daisuke@komi-bakery.com',
                'role' => 'store',
                'department_id' => null,
            ],
            [
                'name' => '伊藤 恵美',
                'email' => 'ito.emiko@komi-bakery.com',
                'role' => 'store',
                'department_id' => null,
            ],
            
            // 洋菓子製造部
            [
                'name' => '山田 一郎',
                'email' => 'yamada.ichiro@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $westernDept->id,
            ],
            [
                'name' => '中村 花子',
                'email' => 'nakamura.hanako@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $westernDept->id,
            ],
            [
                'name' => '小林 次郎',
                'email' => 'kobayashi.jiro@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $westernDept->id,
            ],
            [
                'name' => '加藤 由美',
                'email' => 'kato.yumi@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $westernDept->id,
            ],
            
            // サンドイッチ製造部
            [
                'name' => '吉田 三郎',
                'email' => 'yoshida.saburo@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $sandwichDept->id,
            ],
            [
                'name' => '山本 真由美',
                'email' => 'yamamoto.mayumi@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $sandwichDept->id,
            ],
            [
                'name' => '松本 四郎',
                'email' => 'matsumoto.shiro@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $sandwichDept->id,
            ],
            [
                'name' => '井上 美紀',
                'email' => 'inoue.miki@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $sandwichDept->id,
            ],
            
            // パン製造部
            [
                'name' => '木村 五郎',
                'email' => 'kimura.goro@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $breadDept->id,
            ],
            [
                'name' => '林 香織',
                'email' => 'hayashi.kaori@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $breadDept->id,
            ],
            [
                'name' => '斎藤 六郎',
                'email' => 'saito.rokuro@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $breadDept->id,
            ],
            [
                'name' => '清水 美穂',
                'email' => 'shimizu.miho@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $breadDept->id,
            ],
            
            // チーズケーキ製造部(本店)
            [
                'name' => '阿部 七郎',
                'email' => 'abe.shichiro@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $cheesecakeMainDept->id,
            ],
            [
                'name' => '森 美奈子',
                'email' => 'mori.minako@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $cheesecakeMainDept->id,
            ],
            [
                'name' => '池田 八郎',
                'email' => 'ikeda.hachiro@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $cheesecakeMainDept->id,
            ],
            [
                'name' => '橋本 美香',
                'email' => 'hashimoto.mika@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $cheesecakeMainDept->id,
            ],
            
            // チーズケーキ製造部(南国店)
            [
                'name' => '石川 九郎',
                'email' => 'ishikawa.kuro@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $cheesecakeNangokuDept->id,
            ],
            [
                'name' => '山下 美代',
                'email' => 'yamashita.miyo@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $cheesecakeNangokuDept->id,
            ],
            [
                'name' => '中島 十郎',
                'email' => 'nakajima.juro@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $cheesecakeNangokuDept->id,
            ],
            [
                'name' => '石井 美和',
                'email' => 'ishii.miwa@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $cheesecakeNangokuDept->id,
            ],
            
            // 物流部門
            [
                'name' => '小川 十一郎',
                'email' => 'ogawa.juichiro@komi-bakery.com',
                'role' => 'logistics',
                'department_id' => null,
            ],
            [
                'name' => '前田 美智子',
                'email' => 'maeda.michiko@komi-bakery.com',
                'role' => 'logistics',
                'department_id' => null,
            ],
            [
                'name' => '岡田 十二郎',
                'email' => 'okada.juniro@komi-bakery.com',
                'role' => 'logistics',
                'department_id' => null,
            ],
            [
                'name' => '長谷川 美樹',
                'email' => 'hasegawa.miki@komi-bakery.com',
                'role' => 'logistics',
                'department_id' => null,
            ],
        ];

        foreach ($employees as $employee) {
            User::create([
                'name' => $employee['name'],
                'email' => $employee['email'],
                'password' => Hash::make('password123'),
                'role' => $employee['role'],
                'department_id' => $employee['department_id'],
            ]);
        }

        echo "30名の社員データを作成しました。" . PHP_EOL;
    }
}
