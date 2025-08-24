<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 既存のユーザーを削除
        User::truncate();

        // 管理者ユーザー
        User::create([
            'name' => '田中 テスト正義',
            'email' => 'admin@komi-bakery.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 店舗スタッフ（5人）
        $storeStaff = [
            ['name' => '佐藤 テスト美咲', 'email' => 'sato.misaki@komi-bakery.com'],
            ['name' => '鈴木 テスト健太', 'email' => 'suzuki.kenta@komi-bakery.com'],
            ['name' => '高橋 テスト愛子', 'email' => 'takahashi.aiko@komi-bakery.com'],
            ['name' => '渡辺 テスト大輔', 'email' => 'watanabe.daisuke@komi-bakery.com'],
            ['name' => '伊藤 テスト恵美', 'email' => 'ito.emiko@komi-bakery.com'],
        ];

        foreach ($storeStaff as $staff) {
            User::create([
                'name' => $staff['name'],
                'email' => $staff['email'],
                'password' => Hash::make('password123'),
                'role' => 'store',
            ]);
        }

        // 製造部門ユーザー（15人）
        $manufacturingUsers = [
            // 洋菓子製造部（4人）
            ['name' => '山田 テスト一郎', 'email' => 'yamada.ichiro@komi-bakery.com', 'department' => '洋菓子製造部'],
            ['name' => '中村 テスト花子', 'email' => 'nakamura.hanako@komi-bakery.com', 'department' => '洋菓子製造部'],
            ['name' => '小林 テスト次郎', 'email' => 'kobayashi.jiro@komi-bakery.com', 'department' => '洋菓子製造部'],
            ['name' => '加藤 テスト由美', 'email' => 'kato.yumi@komi-bakery.com', 'department' => '洋菓子製造部'],
            
            // サンドイッチ製造部（3人）
            ['name' => '吉田 テスト三郎', 'email' => 'yoshida.saburo@komi-bakery.com', 'department' => 'サンドイッチ製造部'],
            ['name' => '山本 テスト真由美', 'email' => 'yamamoto.mayumi@komi-bakery.com', 'department' => 'サンドイッチ製造部'],
            ['name' => '松本 テスト四郎', 'email' => 'matsumoto.shiro@komi-bakery.com', 'department' => 'サンドイッチ製造部'],
            
            // パン製造部（4人）
            ['name' => '木村 テスト五郎', 'email' => 'kimura.goro@komi-bakery.com', 'department' => 'パン製造部'],
            ['name' => '林 テスト香織', 'email' => 'hayashi.kaori@komi-bakery.com', 'department' => 'パン製造部'],
            ['name' => '斎藤 テスト六郎', 'email' => 'saito.rokuro@komi-bakery.com', 'department' => 'パン製造部'],
            ['name' => '清水 テスト美穂', 'email' => 'shimizu.miho@komi-bakery.com', 'department' => 'パン製造部'],
            
            // チーズケーキ製造部(本店)（2人）
            ['name' => '阿部 テスト七郎', 'email' => 'abe.shichiro@komi-bakery.com', 'department' => 'チーズケーキ製造部(本店)'],
            ['name' => '森 テスト美奈子', 'email' => 'mori.minako@komi-bakery.com', 'department' => 'チーズケーキ製造部(本店)'],
            
            // チーズケーキ製造部(南国店)（2人）
            ['name' => '池田 テスト八郎', 'email' => 'ikeda.hachiro@komi-bakery.com', 'department' => 'チーズケーキ製造部(南国店)'],
            ['name' => '橋本 テスト美香', 'email' => 'hashimoto.mika@komi-bakery.com', 'department' => 'チーズケーキ製造部(南国店)'],
        ];

        foreach ($manufacturingUsers as $user) {
            $department = Department::where('name', $user['department'])->first();
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password123'),
                'role' => 'manufacturing',
                'department_id' => $department ? $department->id : null,
            ]);
        }

        // 物流部門ユーザー（4人）
        $logisticsUsers = [
            ['name' => '石川 テスト九郎', 'email' => 'ishikawa.kuro@komi-bakery.com'],
            ['name' => '山下 テスト美代', 'email' => 'yamashita.miyo@komi-bakery.com'],
            ['name' => '中島 テスト十郎', 'email' => 'nakajima.juro@komi-bakery.com'],
            ['name' => '石井 テスト美和', 'email' => 'ishii.miwa@komi-bakery.com'],
        ];

        foreach ($logisticsUsers as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password123'),
                'role' => 'logistics',
            ]);
        }

        // 追加のテストユーザー（5人）
        $additionalUsers = [
            ['name' => '小川 テスト十一郎', 'email' => 'ogawa.juichiro@komi-bakery.com', 'role' => 'logistics'],
            ['name' => '前田 テスト美智子', 'email' => 'maeda.michiko@komi-bakery.com', 'role' => 'logistics'],
            ['name' => '岡田 テスト十二郎', 'email' => 'okada.juniro@komi-bakery.com', 'role' => 'logistics'],
            ['name' => '長谷川 テスト美樹', 'email' => 'hasegawa.miki@komi-bakery.com', 'role' => 'logistics'],
            ['name' => '近藤 テスト十三郎', 'email' => 'kondo.jusaburo@komi-bakery.com', 'role' => 'store'],
        ];

        foreach ($additionalUsers as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password123'),
                'role' => $user['role'],
            ]);
        }
    }
}
