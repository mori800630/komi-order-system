<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = Department::all()->keyBy('code');

        $products = [
            // 洋菓子製造部
            [
                'department_code' => 'western_confectionery',
                'name' => '【来店用】 アップルパイ 18cm: メッセージあり (+200円)20文字以内',
                'description' => '18cmサイズのアップルパイ。メッセージプレート付き。',
                'price' => 3200,
                'status' => 'on_sale',
                'requires_packaging' => false,
                'notes' => 'メッセージは20文字以内で入力してください',
            ],
            [
                'department_code' => 'western_confectionery',
                'name' => '【来店用】 アップルパイ 6号 18cm: HappyBirthday金プレート (+100円)',
                'description' => '18cmサイズのアップルパイ。Happy Birthday金プレート付き。',
                'price' => 3100,
                'status' => 'on_sale',
                'requires_packaging' => false,
                'notes' => '金プレート付き',
            ],
            [
                'department_code' => 'western_confectionery',
                'name' => 'チョコバター(フルーツなし) 4号 12cm/2~3名様用',
                'description' => 'チョコレートとバタークリームのケーキ。2-3名様用。',
                'price' => 2500,
                'status' => 'on_sale',
                'requires_packaging' => false,
                'notes' => 'フルーツなし',
            ],
            // チーズケーキ製造部(本店)
            [
                'department_code' => 'cheesecake_main',
                'name' => 'Happy Birthday 金プレート+100円',
                'description' => '本店特製チーズケーキ。Happy Birthday金プレート付き。',
                'price' => 3900,
                'status' => 'on_sale',
                'requires_packaging' => false,
                'notes' => '金プレート付き',
            ],
            // サンドイッチ製造部
            [
                'department_code' => 'sandwich',
                'name' => 'クラブハウスサンドイッチ',
                'description' => 'チキン、レタス、トマトを使用したクラブハウスサンドイッチ。',
                'price' => 800,
                'status' => 'on_sale',
                'requires_packaging' => true,
                'notes' => '冷蔵保存',
            ],
            // パン製造部
            [
                'department_code' => 'bread',
                'name' => '食パン 6枚切り',
                'description' => 'ふわふわの食パン。6枚切り。',
                'price' => 300,
                'status' => 'on_sale',
                'requires_packaging' => true,
                'notes' => '常温保存',
            ],
        ];

        foreach ($products as $product) {
            $departmentCode = $product['department_code'];
            unset($product['department_code']);
            
            if (isset($departments[$departmentCode])) {
                $product['department_id'] = $departments[$departmentCode]->id;
                Product::create($product);
            }
        }
    }
}
