<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Department;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 外部キー制約を無効化
        \DB::statement('PRAGMA foreign_keys = OFF;');
        
        // 既存の商品を削除
        Product::truncate();
        
        // 外部キー制約を再有効化
        \DB::statement('PRAGMA foreign_keys = ON;');

        // 部門を取得
        $cheesecakeDept = Department::where('name', 'チーズケーキ製造部(本店)')->first();
        $westernDept = Department::where('name', '洋菓子製造部')->first();
        $sandwichDept = Department::where('name', 'サンドイッチ製造部')->first();
        $breadDept = Department::where('name', 'パン製造部')->first();

        // チーズケーキ部門の商品
        $cheesecakeProducts = [
            ['name' => '【来店用】窯出しチーズケーキ 飾りなし 7号', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 3500],
            ['name' => '【来店用】抹茶のチーズケーキ 7号', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 3800],
            ['name' => 'Happy Birthday 金プレート+100円 7号', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 3900],
            ['name' => 'チョコプレート(20文字以内)+200円 7号', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 4000],
            ['name' => '上面にメッセージ(30文字以内)+300円 7号', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 4100],
            ['name' => '【来店用】ﾊｯﾋﾟｰﾊﾞｰｽﾃﾞｰ金プレート付チーズケーキ 7号', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 3600],
            ['name' => 'チョコプレート付チーズケーキ 7号 おたんじょうびおめでとう', 'size' => '7号', 'details' => 'おたんじょうびおめでとう', 'price' => 3700],
            ['name' => 'チョコプレート付チーズケーキ 7号 メッセージ指定', 'size' => '7号', 'details' => 'ご希望のメッセージ（20文字以内）備考欄にご記入ください', 'price' => 3700],
            ['name' => 'メッセージ入りチーズケーキ 7号 おたんじょうびおめでとう', 'size' => '7号', 'details' => 'おたんじょうびおめでとう', 'price' => 3800],
            ['name' => 'メッセージ入りチーズケーキ 7号 メッセージ指定', 'size' => '7号', 'details' => 'ご希望のメッセージ（30文字以内）備考欄にご記入ください', 'price' => 3800],
            ['name' => 'フルーツ＆メッセージ入りチーズケーキ 7号 おたんじょうびおめでとう', 'size' => '7号', 'details' => 'おたんじょうびおめでとう', 'price' => 4000],
            ['name' => 'フルーツ＆メッセージ入りチーズケーキ 7号 メッセージ指定', 'size' => '7号', 'details' => 'ご希望のメッセージ（20文字以内）備考欄にご記入ください', 'price' => 4000],
            ['name' => 'お顔を書いたチーズケーキ 7号 おたんじょうびおめでとう', 'size' => '7号', 'details' => 'おたんじょうびおめでとう', 'price' => 4000],
            ['name' => 'お顔を書いたチーズケーキ 7号 メッセージ指定', 'size' => '7号', 'details' => 'ご希望のメッセージ（ひらがなのみで18文字前後）備考欄にご記入ください', 'price' => 4000],
            ['name' => 'お顔を書いたチーズケーキ 7号 メッセージなし', 'size' => '7号', 'details' => 'メッセージなし', 'price' => 4000],
            ['name' => 'お花デコチーズケーキ 7号 おたんじょうびおめでとう', 'size' => '7号', 'details' => 'おたんじょうびおめでとう', 'price' => 4000],
            ['name' => 'お花デコチーズケーキ 7号 メッセージ指定', 'size' => '7号', 'details' => 'ご希望のメッセージ（30文字以内）備考欄にご記入ください', 'price' => 4000],
            ['name' => 'クリーム多めチーズケーキデコ 7号 おたんじょうびおめでとう', 'size' => '7号', 'details' => 'おたんじょうびおめでとう', 'price' => 5800],
            ['name' => 'クリーム多めチーズケーキデコ 7号 メッセージ指定', 'size' => '7号', 'details' => 'ご希望のメッセージ（20文字以内）備考欄にご記入ください', 'price' => 5800],
            ['name' => 'クリーム多めチーズケーキデコ 7号 メッセージなし', 'size' => '7号', 'details' => 'メッセージなし', 'price' => 5800],
            ['name' => 'フルーツ多めチーズケーキデコ 7号 おたんじょうびおめでとう', 'size' => '7号', 'details' => 'おたんじょうびおめでとう', 'price' => 5800],
            ['name' => 'フルーツ多めチーズケーキデコ 7号 メッセージ指定', 'size' => '7号', 'details' => 'ご希望のメッセージ（20文字以内）備考欄にご記入ください', 'price' => 5800],
            ['name' => 'フルーツ多めチーズケーキデコ 7号 メッセージなし', 'size' => '7号', 'details' => 'メッセージなし', 'price' => 5800],
        ];

        foreach ($cheesecakeProducts as $product) {
            Product::create([
                'name' => $product['name'],
                'name_kana' => $product['name'],
                'size' => $product['size'],
                'details' => $product['details'],
                'price' => $product['price'],
                'department_id' => $cheesecakeDept->id,
                'status' => 'on_sale',
                'requires_packaging' => true,
                'decoration' => 'available',
            ]);
        }

        // 洋菓子部門の商品
        $westernProducts = [
            // 生クリームデコレーション
            ['name' => '生クリームデコレーション 4号', 'size' => '4号', 'details' => '12cm/2～3名様用', 'price' => 2500],
            ['name' => '生クリームデコレーション 5号', 'size' => '5号', 'details' => '15cm/4～6名様用', 'price' => 3800],
            ['name' => '生クリームデコレーション 6号', 'size' => '6号', 'details' => '18cm/6～8名様用', 'price' => 4800],
            ['name' => '生クリームデコレーション 7号', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 5800],
            ['name' => '生クリームデコレーション 8号', 'size' => '8号', 'details' => '24cm/10～14名様用', 'price' => 7000],
            
            // 生チョコデコレーション
            ['name' => '生チョコデコレーション 4号', 'size' => '4号', 'details' => '12cm/2～3名様用', 'price' => 2500],
            ['name' => '生チョコデコレーション 5号', 'size' => '5号', 'details' => '15cm/4～6名様用', 'price' => 3800],
            ['name' => '生チョコデコレーション 6号', 'size' => '6号', 'details' => '18cm/6～8名様用', 'price' => 4800],
            ['name' => '生チョコデコレーション 7号', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 5800],
            ['name' => '生チョコデコレーション 8号', 'size' => '8号', 'details' => '24cm/10～14名様用', 'price' => 7000],
            
            // ハーフ＆ハーフ
            ['name' => 'ハーフ＆ハーフ 4号', 'size' => '4号', 'details' => '12cm/2～3名様用', 'price' => 2850],
            ['name' => 'ハーフ＆ハーフ 5号', 'size' => '5号', 'details' => '15cm/4～6名様用', 'price' => 4150],
            ['name' => 'ハーフ＆ハーフ 6号', 'size' => '6号', 'details' => '18cm/6～8名様用', 'price' => 5150],
            ['name' => 'ハーフ＆ハーフ 7号', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 6150],
            ['name' => 'ハーフ＆ハーフ 8号', 'size' => '8号', 'details' => '24cm/10～14名様用', 'price' => 7350],
            
            // バタークリームデコ
            ['name' => 'バタークリームデコ(フルーツなし) 4号', 'size' => '4号', 'details' => '12cm/2～3名様用', 'price' => 2500],
            ['name' => 'バタークリームデコ(フルーツなし) 5号', 'size' => '5号', 'details' => '15cm/4～6名様用', 'price' => 3800],
            ['name' => 'バタークリームデコ(フルーツなし) 6号', 'size' => '6号', 'details' => '18cm/6～8名様用', 'price' => 4800],
            ['name' => 'バタークリームデコ(フルーツなし) 7号', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 5800],
            ['name' => 'バタークリームデコ(フルーツなし) 8号', 'size' => '8号', 'details' => '24cm/10～14名様用', 'price' => 7000],
            
            // チョコバター
            ['name' => 'チョコバター(フルーツなし) 4号', 'size' => '4号', 'details' => '12cm/2～3名様用', 'price' => 2500],
            ['name' => 'チョコバター(フルーツなし) 5号', 'size' => '5号', 'details' => '15cm/4～6名様用', 'price' => 3800],
            ['name' => 'チョコバター(フルーツなし) 6号', 'size' => '6号', 'details' => '18cm/6～8名様用', 'price' => 4800],
            ['name' => 'チョコバター(フルーツなし) 7号', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 5800],
            ['name' => 'チョコバター(フルーツなし) 8号', 'size' => '8号', 'details' => '24cm/10～14名様用', 'price' => 7000],
            
            // フリルケーキ
            ['name' => 'フリルケーキ(季節のフルーツ) 4号', 'size' => '4号', 'details' => '12cm/2～3名様用', 'price' => 2800],
            ['name' => 'フリルケーキ(季節のフルーツ) 5号', 'size' => '5号', 'details' => '15cm/4～6名様用', 'price' => 4100],
            ['name' => 'フリルケーキ(季節のフルーツ) 6号', 'size' => '6号', 'details' => '18cm/6～8名様用', 'price' => 5100],
            ['name' => 'フリルケーキ(季節のフルーツ) 7号', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 6100],
            ['name' => 'フリルケーキ(季節のフルーツ) 8号', 'size' => '8号', 'details' => '24cm/10～14名様用', 'price' => 7300],
            
            // ガナッシュショコラ
            ['name' => 'ガナッシュショコラ(季節のフルーツ) 4号', 'size' => '4号', 'details' => '12cm/2～3名様用', 'price' => 2800],
            ['name' => 'ガナッシュショコラ(季節のフルーツ) 5号', 'size' => '5号', 'details' => '15cm/4～6名様用', 'price' => 4100],
            ['name' => 'ガナッシュショコラ(季節のフルーツ) 6号', 'size' => '6号', 'details' => '18cm/6～8名様用', 'price' => 5100],
            ['name' => 'ガナッシュショコラ(季節のフルーツ) 7号', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 6100],
            ['name' => 'ガナッシュショコラ(季節のフルーツ) 8号', 'size' => '8号', 'details' => '24cm/10～14名様用', 'price' => 7300],
            
            // 抹茶クリーム
            ['name' => '抹茶クリーム 4号', 'size' => '4号', 'details' => '12cm/2～3名様用', 'price' => 2800],
            ['name' => '抹茶クリーム 5号', 'size' => '5号', 'details' => '15cm/4～6名様用', 'price' => 4100],
            ['name' => '抹茶クリーム 6号', 'size' => '6号', 'details' => '18cm/6～8名様用', 'price' => 5100],
            ['name' => '抹茶クリーム 7号', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 6100],
            ['name' => '抹茶クリーム 8号', 'size' => '8号', 'details' => '24cm/10～14名様用', 'price' => 7300],
            
            // モンブランデコレーション
            ['name' => 'モンブランデコレーション 4号', 'size' => '4号', 'details' => '12cm/2～3名様用', 'price' => 2800],
            ['name' => 'モンブランデコレーション 5号', 'size' => '5号', 'details' => '15cm/4～6名様用', 'price' => 4100],
            ['name' => 'モンブランデコレーション 6号', 'size' => '6号', 'details' => '18cm/6～8名様用', 'price' => 5100],
            ['name' => 'モンブランデコレーション 7号', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 6100],
            ['name' => 'モンブランデコレーション 8号', 'size' => '8号', 'details' => '24cm/10～14名様用', 'price' => 7300],
            
            // ガトーショコラ
            ['name' => 'ガトーショコラ 6号 メッセージなし', 'size' => '6号', 'details' => '18cm：メッセージなし', 'price' => 5000],
            ['name' => 'ガトーショコラ 6号 メッセージあり', 'size' => '6号', 'details' => '18cm：メッセージあり(20文字以内)', 'price' => 5000],
            
            // 丸形２段
            ['name' => '丸形２段 小', 'size' => 'なし', 'details' => '小：上12cm+下18cm', 'price' => 7300],
            ['name' => '丸形２段 大', 'size' => 'なし', 'details' => '大：上18cm+下24cm', 'price' => 11800],
            
            // アップルパイ
            ['name' => '【来店用】アップルパイ 6号 メッセージなし', 'size' => '6号', 'details' => '18cm：メッセージなし', 'price' => 3000],
            ['name' => '【来店用】アップルパイ 6号 金プレート付', 'size' => '6号', 'details' => '18cm：HappyBirthday金プレート(+100円)', 'price' => 3100],
            ['name' => '【来店用】アップルパイ メッセージあり', 'size' => 'なし', 'details' => '18cm：メッセージあり(+200円)20文字以内', 'price' => 3200],
            
            // クッキーメダル
            ['name' => 'クッキーメダル がんばったね', 'size' => 'なし', 'details' => 'がんばったね', 'price' => 430],
            ['name' => 'クッキーメダル おつかれさま', 'size' => 'なし', 'details' => 'おつかれさま', 'price' => 430],
            ['name' => 'クッキーメダル おめでとう', 'size' => 'なし', 'details' => 'おめでとう', 'price' => 430],
            ['name' => 'クッキーメダル ありがとう', 'size' => 'なし', 'details' => 'ありがとう', 'price' => 430],
            ['name' => 'クッキーメダル だいすき', 'size' => 'なし', 'details' => 'だいすき', 'price' => 430],
            ['name' => 'クッキーメダル スマイル', 'size' => 'なし', 'details' => 'スマイル', 'price' => 430],
            
            // フルーツロール
            ['name' => 'フルーツロール メッセージなし', 'size' => 'なし', 'details' => '約16cm：メッセージなし', 'price' => 1700],
            ['name' => 'フルーツロール 金プレート付', 'size' => 'なし', 'details' => '約16cm：HappyBirthday金プレート(+100円)', 'price' => 1800],
            ['name' => 'フルーツロール メッセージあり', 'size' => 'なし', 'details' => '約16cm：メッセージあり(+200円)20文字以内', 'price' => 1900],
            
            // プチケーキ
            ['name' => 'プチケーキ 5個入', 'size' => 'なし', 'details' => '5個入', 'price' => 900],
            ['name' => 'プチケーキ 10個入', 'size' => 'なし', 'details' => '10個入', 'price' => 1800],
            
            // ロイヤルチーズ
            ['name' => '【来店用】ロイヤルチーズ 4個入 冷凍', 'size' => 'なし', 'details' => '4個入／冷凍', 'price' => 770],
            ['name' => '【来店用】ロイヤルチーズ 4個入 冷蔵', 'size' => 'なし', 'details' => '4個入／冷蔵', 'price' => 770],
            ['name' => '【来店用】ロイヤルチーズ 6個入 冷凍', 'size' => 'なし', 'details' => '6個入／冷凍', 'price' => 1190],
            ['name' => '【来店用】ロイヤルチーズ 6個入 冷蔵', 'size' => 'なし', 'details' => '6個入／冷蔵', 'price' => 1190],
            ['name' => '【来店用】ロイヤルチーズ 14個入 冷凍', 'size' => 'なし', 'details' => '14個入／冷凍', 'price' => 2740],
            ['name' => '【来店用】ロイヤルチーズ 14個入 冷蔵', 'size' => 'なし', 'details' => '14個入／冷蔵', 'price' => 2740],
            
            // 濃厚ショコラ
            ['name' => '【来店用】濃厚ショコラ 4個入 冷凍', 'size' => 'なし', 'details' => '4個入／冷凍', 'price' => 770],
            ['name' => '【来店用】濃厚ショコラ 4個入 冷蔵', 'size' => 'なし', 'details' => '4個入／冷蔵', 'price' => 770],
            ['name' => '【来店用】濃厚ショコラ 6個入 冷凍', 'size' => 'なし', 'details' => '6個入／冷凍', 'price' => 1190],
            ['name' => '【来店用】濃厚ショコラ 6個入 冷蔵', 'size' => 'なし', 'details' => '6個入／冷蔵', 'price' => 1190],
            ['name' => '【来店用】濃厚ショコラ 14個入 冷凍', 'size' => 'なし', 'details' => '14個入／冷凍', 'price' => 2740],
            ['name' => '【来店用】濃厚ショコラ 14個入 冷蔵', 'size' => 'なし', 'details' => '14個入／冷蔵', 'price' => 2740],
            
            // ロイヤルチーズと濃厚ショコラのセット
            ['name' => '【来店用】ロイヤルチーズと濃厚ショコラのセット 6個入 冷凍', 'size' => 'なし', 'details' => '6個入／冷凍', 'price' => 1190],
            ['name' => '【来店用】ロイヤルチーズと濃厚ショコラのセット 6個入 冷蔵', 'size' => 'なし', 'details' => '6個入／冷蔵', 'price' => 1190],
            ['name' => '【来店用】ロイヤルチーズと濃厚ショコラのセット 14個入 冷凍', 'size' => 'なし', 'details' => '14個入／冷凍', 'price' => 2740],
            ['name' => '【来店用】ロイヤルチーズと濃厚ショコラのセット 14個入 冷蔵', 'size' => 'なし', 'details' => '14個入／冷蔵', 'price' => 2740],
            
            // キャンドル
            ['name' => 'ストライプキャンドル５本入 小', 'size' => 'なし', 'details' => '小：約12cm', 'price' => 30],
            ['name' => 'ストライプキャンドル５本入 大', 'size' => 'なし', 'details' => '大：約18cm', 'price' => 50],
            ['name' => 'ナンバーキャンドル', 'size' => 'なし', 'details' => '備考欄にご希望のナンバーをご記入ください', 'price' => 120],
        ];

        foreach ($westernProducts as $product) {
            Product::create([
                'name' => $product['name'],
                'name_kana' => $product['name'],
                'size' => $product['size'],
                'details' => $product['details'],
                'price' => $product['price'],
                'department_id' => $westernDept->id,
                'status' => 'on_sale',
                'requires_packaging' => true,
                'decoration' => 'available',
            ]);
        }

        // サンドイッチ製造部の商品
        $sandwichProducts = [
            // 基本サンドイッチシリーズ
            ['name' => 'ミックスサンド（3個入）', 'size' => 'なし', 'details' => '定番の組み合わせ', 'price' => 330],
            ['name' => 'ミックス特盛サンド（3個入）', 'size' => 'なし', 'details' => 'ボリュームアップ版', 'price' => 350],
            ['name' => 'ハムサンド', 'size' => 'なし', 'details' => 'シンプルなハムサンド', 'price' => 350],
            ['name' => 'たまごサンド', 'size' => 'なし', 'details' => 'ふわふわ卵サンド', 'price' => 190],
            ['name' => 'ツナサンド', 'size' => 'なし', 'details' => 'ツナマヨサンド', 'price' => 190],
            
            // 特製サンドイッチ
            ['name' => 'うずまん', 'size' => 'なし', 'details' => 'こみベーカリー特製', 'price' => 380],
            ['name' => 'カツサンド（3個入）', 'size' => 'なし', 'details' => 'サクサクカツサンド', 'price' => 380],
            ['name' => 'ポークサンド', 'size' => 'なし', 'details' => 'ジューシーポーク', 'price' => 380],
            ['name' => 'ソフトビーフサンド', 'size' => 'なし', 'details' => '柔らかビーフ', 'price' => 400],
            ['name' => 'プレミアムサンド', 'size' => 'なし', 'details' => '上質な食材使用', 'price' => 450],
            
            // コッペパンシリーズ
            ['name' => 'きなこ揚げパン', 'size' => 'なし', 'details' => '懐かしい味', 'price' => 160],
            ['name' => 'ココクリーム', 'size' => 'なし', 'details' => 'チョコクリーム', 'price' => 180],
            ['name' => 'いちごジャム', 'size' => 'なし', 'details' => '甘酸っぱいジャム', 'price' => 180],
            ['name' => 'ピーナッツクリーム', 'size' => 'なし', 'details' => '香ばしいピーナッツ', 'price' => 180],
            ['name' => 'カレーパン風コッペ', 'size' => 'なし', 'details' => 'スパイシー', 'price' => 200],
            
            // ロールサンドシリーズ
            ['name' => '京風ロールサンド', 'size' => 'なし', 'details' => '上品な味付け', 'price' => 380],
            ['name' => 'ハーブロールサンド', 'size' => 'なし', 'details' => 'ハーブ香る', 'price' => 350],
            ['name' => 'ビーフロールサンド', 'size' => 'なし', 'details' => 'ボリューム満点', 'price' => 400],
        ];

        foreach ($sandwichProducts as $product) {
            Product::create([
                'name' => $product['name'],
                'name_kana' => $product['name'],
                'size' => $product['size'],
                'details' => $product['details'],
                'price' => $product['price'],
                'department_id' => $sandwichDept->id,
                'status' => 'on_sale',
                'requires_packaging' => true,
                'decoration' => 'unavailable',
            ]);
        }

        // パン製造部の商品
        $breadProducts = [
            // 食パンシリーズ
            ['name' => 'みんなで美味しい食パン', 'size' => 'なし', 'details' => '定番の食パン', 'price' => 190],
            ['name' => '特上食パン', 'size' => 'なし', 'details' => '高級食パン', 'price' => 200],
            ['name' => 'クリーム食パン', 'size' => 'なし', 'details' => 'なめらかクリーム入り', 'price' => 200],
            ['name' => '玄米食パン', 'size' => 'なし', 'details' => '健康志向', 'price' => 230],
            
            // 手作りパン基本シリーズ
            ['name' => 'クロワッサン', 'size' => 'なし', 'details' => 'バターたっぷり', 'price' => 100],
            ['name' => '食パン', 'size' => 'なし', 'details' => 'シンプルな食パン', 'price' => 100],
            ['name' => 'あんぱん', 'size' => 'なし', 'details' => '粒あん入り', 'price' => 120],
            ['name' => 'ケーキドーナツ', 'size' => 'なし', 'details' => 'ふわふわドーナツ', 'price' => 120],
            ['name' => 'ソフトフランス', 'size' => 'なし', 'details' => '柔らかフランスパン', 'price' => 100],
            
            // 菓子パンシリーズ
            ['name' => 'メロンパン', 'size' => 'なし', 'details' => 'クッキー生地がサクサク', 'price' => 190],
            ['name' => 'カレーパン', 'size' => 'なし', 'details' => 'スパイシーカレー', 'price' => 160],
            ['name' => 'チョコロールワッサン', 'size' => 'なし', 'details' => 'チョコたっぷり', 'price' => 200],
            ['name' => 'あずきクロワッサン', 'size' => 'なし', 'details' => '和洋折衷', 'price' => 200],
            ['name' => 'クリームパン', 'size' => 'なし', 'details' => 'なめらかカスタード', 'price' => 200],
            
            // 惣菜パンシリーズ
            ['name' => 'ピザパン', 'size' => 'なし', 'details' => 'チーズとトマト', 'price' => 180],
            ['name' => 'ハムロール', 'size' => 'なし', 'details' => 'ハム巻きパン', 'price' => 140],
            ['name' => 'チーズフランス', 'size' => 'なし', 'details' => 'チーズがとろ〜り', 'price' => 220],
            ['name' => 'ウインナーパン', 'size' => 'なし', 'details' => 'ジューシーウインナー', 'price' => 200],
            ['name' => 'コーンパン', 'size' => 'なし', 'details' => '甘いコーン', 'price' => 180],
            
            // 高級パンシリーズ
            ['name' => 'デニッシュ系各種', 'size' => 'なし', 'details' => 'バター層がサクサク', 'price' => 300],
            ['name' => 'ブリオッシュ', 'size' => 'なし', 'details' => 'リッチな味わい', 'price' => 250],
            ['name' => 'フォカッチャ', 'size' => 'なし', 'details' => 'イタリアンスタイル', 'price' => 300],
            ['name' => 'ベーグル', 'size' => 'なし', 'details' => 'もちもち食感', 'price' => 200],
            
            // 季節・限定商品
            ['name' => '季節のパンお任せセット', 'size' => 'なし', 'details' => '通年', 'price' => 1350],
            ['name' => 'シェフのこだわり食事パンセット', 'size' => 'なし', 'details' => '通年', 'price' => 1350],
            ['name' => '桜パン', 'size' => 'なし', 'details' => '春限定', 'price' => 220],
            ['name' => 'カボチャパン', 'size' => 'なし', 'details' => '秋限定', 'price' => 200],
        ];

        foreach ($breadProducts as $product) {
            Product::create([
                'name' => $product['name'],
                'name_kana' => $product['name'],
                'size' => $product['size'],
                'details' => $product['details'],
                'price' => $product['price'],
                'department_id' => $breadDept->id,
                'status' => 'on_sale',
                'requires_packaging' => true,
                'decoration' => 'unavailable',
            ]);
        }
    }
}
