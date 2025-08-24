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
                'name' => '田中 テスト正義',
                'email' => 'tanaka.masayoshi@komi-bakery.com',
                'role' => 'admin',
                'department_id' => null,
            ],
            
            // 店舗スタッフ
            [
                'name' => '佐藤 テスト美咲',
                'email' => 'sato.misaki@komi-bakery.com',
                'role' => 'store',
                'department_id' => null,
            ],
            [
                'name' => '鈴木 テスト健太',
                'email' => 'suzuki.kenta@komi-bakery.com',
                'role' => 'store',
                'department_id' => null,
            ],
            [
                'name' => '高橋 テスト愛子',
                'email' => 'takahashi.aiko@komi-bakery.com',
                'role' => 'store',
                'department_id' => null,
            ],
            [
                'name' => '渡辺 テスト大輔',
                'email' => 'watanabe.daisuke@komi-bakery.com',
                'role' => 'store',
                'department_id' => null,
            ],
            [
                'name' => '伊藤 テスト恵美',
                'email' => 'ito.emiko@komi-bakery.com',
                'role' => 'store',
                'department_id' => null,
            ],
            
            // 洋菓子製造部
            [
                'name' => '山田 テスト一郎',
                'email' => 'yamada.ichiro@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $westernDept->id,
            ],
            [
                'name' => '中村 テスト花子',
                'email' => 'nakamura.hanako@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $westernDept->id,
            ],
            [
                'name' => '小林 テスト次郎',
                'email' => 'kobayashi.jiro@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $westernDept->id,
            ],
            [
                'name' => '加藤 テスト由美',
                'email' => 'kato.yumi@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $westernDept->id,
            ],
            
            // サンドイッチ製造部
            [
                'name' => '吉田 テスト三郎',
                'email' => 'yoshida.saburo@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $sandwichDept->id,
            ],
            [
                'name' => '山本 テスト真由美',
                'email' => 'yamamoto.mayumi@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $sandwichDept->id,
            ],
            [
                'name' => '松本 テスト四郎',
                'email' => 'matsumoto.shiro@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $sandwichDept->id,
            ],
            [
                'name' => '井上 テスト美紀',
                'email' => 'inoue.miki@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $sandwichDept->id,
            ],
            
            // パン製造部
            [
                'name' => '木村 テスト五郎',
                'email' => 'kimura.goro@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $breadDept->id,
            ],
            [
                'name' => '林 テスト香織',
                'email' => 'hayashi.kaori@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $breadDept->id,
            ],
            [
                'name' => '斎藤 テスト六郎',
                'email' => 'saito.rokuro@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $breadDept->id,
            ],
            [
                'name' => '清水 テスト美穂',
                'email' => 'shimizu.miho@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $breadDept->id,
            ],
            
            // チーズケーキ製造部(本店)
            [
                'name' => '阿部 テスト七郎',
                'email' => 'abe.shichiro@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $cheesecakeMainDept->id,
            ],
            [
                'name' => '森 テスト美奈子',
                'email' => 'mori.minako@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $cheesecakeMainDept->id,
            ],
            [
                'name' => '池田 テスト八郎',
                'email' => 'ikeda.hachiro@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $cheesecakeMainDept->id,
            ],
            [
                'name' => '橋本 テスト美香',
                'email' => 'hashimoto.mika@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $cheesecakeMainDept->id,
            ],
            
            // チーズケーキ製造部(南国店)
            [
                'name' => '石川 テスト九郎',
                'email' => 'ishikawa.kuro@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $cheesecakeNangokuDept->id,
            ],
            [
                'name' => '山下 テスト美代',
                'email' => 'yamashita.miyo@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $cheesecakeNangokuDept->id,
            ],
            [
                'name' => '中島 テスト十郎',
                'email' => 'nakajima.juro@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $cheesecakeNangokuDept->id,
            ],
            [
                'name' => '石井 テスト美和',
                'email' => 'ishii.miwa@komi-bakery.com',
                'role' => 'manufacturing',
                'department_id' => $cheesecakeNangokuDept->id,
            ],
            
            // 物流部門
            [
                'name' => '小川 テスト十一郎',
                'email' => 'ogawa.juichiro@komi-bakery.com',
                'role' => 'logistics',
                'department_id' => null,
            ],
            [
                'name' => '前田 テスト美智子',
                'email' => 'maeda.michiko@komi-bakery.com',
                'role' => 'logistics',
                'department_id' => null,
            ],
            [
                'name' => '岡田 テスト十二郎',
                'email' => 'okada.juniro@komi-bakery.com',
                'role' => 'logistics',
                'department_id' => null,
            ],
            [
                'name' => '長谷川 テスト美樹',
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
