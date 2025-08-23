<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Department;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 部門を取得
        $cheesecakeDept = Department::where('name', 'チーズケーキ製造部(本店)')->first();
        $westernDept = Department::where('name', '洋菓子製造部')->first();
        $accessoryDept = Department::where('name', '洋菓子製造部')->first(); // アクセサリーは洋菓子部門に含める

        // チーズケーキ部門の商品
        $cheesecakeProducts = [
            ['name' => '【来店用】窯出しチーズケーキ 飾りなし', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 3500],
            ['name' => '【来店用】抹茶のチーズケーキ', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 3800],
            ['name' => 'Happy Birthday 金プレート+100円', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 3900],
            ['name' => 'チョコプレート(20文字以内)+200円', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 4000],
            ['name' => '上面にメッセージ(30文字以内)+300円', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 4100],
            ['name' => '【来店用】ﾊｯﾋﾟｰﾊﾞｰｽﾃﾞｰ金プレート付チーズケーキ', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 3600],
            ['name' => 'チョコプレート付チーズケーキ', 'size' => '7号', 'details' => 'おたんじょうびおめでとう', 'price' => 3700],
            ['name' => 'チーズケーキ（メッセージ指定）', 'size' => '7号', 'details' => 'ご希望のメッセージ（20文字以内）備考欄にご記入ください', 'price' => 3700],
            ['name' => 'メッセージ入りチーズケーキ', 'size' => '7号', 'details' => 'おたんじょうびおめでとう', 'price' => 3800],
            ['name' => 'メッセージ入りチーズケーキ（メッセージ指定）', 'size' => '7号', 'details' => 'ご希望のメッセージ（30文字以内）備考欄にご記入ください', 'price' => 3800],
            ['name' => 'フルーツ＆メッセージ入りチーズケーキ', 'size' => '7号', 'details' => 'おたんじょうびおめでとう', 'price' => 4000],
            ['name' => 'フルーツ＆メッセージ入りチーズケーキ（メッセージ指定）', 'size' => '7号', 'details' => 'ご希望のメッセージ（20文字以内）備考欄にご記入ください', 'price' => 4000],
            ['name' => 'お顔を書いたチーズケーキ', 'size' => '7号', 'details' => 'おたんじょうびおめでとう', 'price' => 4000],
            ['name' => 'お顔を書いたチーズケーキ（メッセージ指定）', 'size' => '7号', 'details' => 'ご希望のメッセージ（ひらがなのみで18文字前後）備考欄にご記入ください', 'price' => 4000],
            ['name' => 'お顔を書いたチーズケーキ（メッセージなし）', 'size' => '7号', 'details' => 'メッセージなし', 'price' => 4000],
            ['name' => 'お花デコチーズケーキ', 'size' => '7号', 'details' => 'おたんじょうびおめでとう', 'price' => 4000],
            ['name' => 'お花デコチーズケーキ（メッセージ指定）', 'size' => '7号', 'details' => 'ご希望のメッセージ（30文字以内）備考欄にご記入ください', 'price' => 4000],
            ['name' => 'クリーム多めチーズケーキデコ', 'size' => '7号', 'details' => 'おたんじょうびおめでとう', 'price' => 5800],
            ['name' => 'クリーム多めチーズケーキデコ（メッセージ指定）', 'size' => '7号', 'details' => 'ご希望のメッセージ（20文字以内）備考欄にご記入ください', 'price' => 5800],
            ['name' => 'クリーム多めチーズケーキデコ（メッセージなし）', 'size' => '7号', 'details' => 'メッセージなし', 'price' => 5800],
            ['name' => 'フルーツ多めチーズケーキデコ', 'size' => '7号', 'details' => 'おたんじょうびおめでとう', 'price' => 5800],
            ['name' => 'フルーツ多めチーズケーキデコ（メッセージ指定）', 'size' => '7号', 'details' => 'ご希望のメッセージ（20文字以内）備考欄にご記入ください', 'price' => 5800],
            ['name' => 'フルーツ多めチーズケーキデコ（メッセージなし）', 'size' => '7号', 'details' => 'メッセージなし', 'price' => 5800],
        ];

        foreach ($cheesecakeProducts as $product) {
            Product::create([
                'name' => $product['name'],
                'name_kana' => $product['name'],
                'size' => $product['size'],
                'details' => $product['details'],
                'price' => $product['price'],
                'department_id' => $cheesecakeDept->id,
                'sales_status' => 'on_sale',
                'requires_packaging' => true,
                'decoration' => 'available',
            ]);
        }

        // 洋菓子部門の商品
        $westernProducts = [
            // 生クリームデコレーション
            ['name' => '生クリームデコレーション', 'size' => '4号', 'details' => '12cm/2～3名様用', 'price' => 2500],
            ['name' => '生クリームデコレーション', 'size' => '5号', 'details' => '15cm/4～6名様用', 'price' => 3800],
            ['name' => '生クリームデコレーション', 'size' => '6号', 'details' => '18cm/6～8名様用', 'price' => 4800],
            ['name' => '生クリームデコレーション', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 5800],
            ['name' => '生クリームデコレーション', 'size' => '8号', 'details' => '24cm/10～14名様用', 'price' => 7000],
            
            // 生チョコデコレーション
            ['name' => '生チョコデコレーション', 'size' => '4号', 'details' => '12cm/2～3名様用', 'price' => 2500],
            ['name' => '生チョコデコレーション', 'size' => '5号', 'details' => '15cm/4～6名様用', 'price' => 3800],
            ['name' => '生チョコデコレーション', 'size' => '6号', 'details' => '18cm/6～8名様用', 'price' => 4800],
            ['name' => '生チョコデコレーション', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 5800],
            ['name' => '生チョコデコレーション', 'size' => '8号', 'details' => '24cm/10～14名様用', 'price' => 7000],
            
            // ハーフ＆ハーフ
            ['name' => 'ハーフ＆ハーフ', 'size' => '4号', 'details' => '12cm/2～3名様用', 'price' => 2850],
            ['name' => 'ハーフ＆ハーフ', 'size' => '5号', 'details' => '15cm/4～6名様用', 'price' => 4150],
            ['name' => 'ハーフ＆ハーフ', 'size' => '6号', 'details' => '18cm/6～8名様用', 'price' => 5150],
            ['name' => 'ハーフ＆ハーフ', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 6150],
            ['name' => 'ハーフ＆ハーフ', 'size' => '8号', 'details' => '24cm/10～14名様用', 'price' => 7350],
            
            // バタークリームデコ
            ['name' => 'バタークリームデコ(フルーツなし)', 'size' => '4号', 'details' => '12cm/2～3名様用', 'price' => 2500],
            ['name' => 'バタークリームデコ(フルーツなし)', 'size' => '5号', 'details' => '15cm/4～6名様用', 'price' => 3800],
            ['name' => 'バタークリームデコ(フルーツなし)', 'size' => '6号', 'details' => '18cm/6～8名様用', 'price' => 4800],
            ['name' => 'バタークリームデコ(フルーツなし)', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 5800],
            ['name' => 'バタークリームデコ(フルーツなし)', 'size' => '8号', 'details' => '24cm/10～14名様用', 'price' => 7000],
            
            // チョコバター
            ['name' => 'チョコバター(フルーツなし)', 'size' => '4号', 'details' => '12cm/2～3名様用', 'price' => 2500],
            ['name' => 'チョコバター(フルーツなし)', 'size' => '5号', 'details' => '15cm/4～6名様用', 'price' => 3800],
            ['name' => 'チョコバター(フルーツなし)', 'size' => '6号', 'details' => '18cm/6～8名様用', 'price' => 4800],
            ['name' => 'チョコバター(フルーツなし)', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 5800],
            ['name' => 'チョコバター(フルーツなし)', 'size' => '8号', 'details' => '24cm/10～14名様用', 'price' => 7000],
            
            // フリルケーキ
            ['name' => 'フリルケーキ(季節のフルーツ)', 'size' => '4号', 'details' => '12cm/2～3名様用', 'price' => 2800],
            ['name' => 'フリルケーキ(季節のフルーツ)', 'size' => '5号', 'details' => '15cm/4～6名様用', 'price' => 4100],
            ['name' => 'フリルケーキ(季節のフルーツ)', 'size' => '6号', 'details' => '18cm/6～8名様用', 'price' => 5100],
            ['name' => 'フリルケーキ(季節のフルーツ)', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 6100],
            ['name' => 'フリルケーキ(季節のフルーツ)', 'size' => '8号', 'details' => '24cm/10～14名様用', 'price' => 7300],
            
            // ガナッシュショコラ
            ['name' => 'ガナッシュショコラ(季節のフルーツ)', 'size' => '4号', 'details' => '12cm/2～3名様用', 'price' => 2800],
            ['name' => 'ガナッシュショコラ(季節のフルーツ)', 'size' => '5号', 'details' => '15cm/4～6名様用', 'price' => 4100],
            ['name' => 'ガナッシュショコラ(季節のフルーツ)', 'size' => '6号', 'details' => '18cm/6～8名様用', 'price' => 5100],
            ['name' => 'ガナッシュショコラ(季節のフルーツ)', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 6100],
            ['name' => 'ガナッシュショコラ(季節のフルーツ)', 'size' => '8号', 'details' => '24cm/10～14名様用', 'price' => 7300],
            
            // 抹茶クリーム
            ['name' => '抹茶クリーム', 'size' => '4号', 'details' => '12cm/2～3名様用', 'price' => 2800],
            ['name' => '抹茶クリーム', 'size' => '5号', 'details' => '15cm/4～6名様用', 'price' => 4100],
            ['name' => '抹茶クリーム', 'size' => '6号', 'details' => '18cm/6～8名様用', 'price' => 5100],
            ['name' => '抹茶クリーム', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 6100],
            ['name' => '抹茶クリーム', 'size' => '8号', 'details' => '24cm/10～14名様用', 'price' => 7300],
            
            // モンブランデコレーション
            ['name' => 'モンブランデコレーション', 'size' => '4号', 'details' => '12cm/2～3名様用', 'price' => 2800],
            ['name' => 'モンブランデコレーション', 'size' => '5号', 'details' => '15cm/4～6名様用', 'price' => 4100],
            ['name' => 'モンブランデコレーション', 'size' => '6号', 'details' => '18cm/6～8名様用', 'price' => 5100],
            ['name' => 'モンブランデコレーション', 'size' => '7号', 'details' => '21cm/8～12名様用', 'price' => 6100],
            ['name' => 'モンブランデコレーション', 'size' => '8号', 'details' => '24cm/10～14名様用', 'price' => 7300],
            
            // ガトーショコラ
            ['name' => 'ガトーショコラ', 'size' => '6号', 'details' => '18cm：メッセージなし', 'price' => 5000],
            ['name' => 'ガトーショコラ', 'size' => '6号', 'details' => '18cm：メッセージあり(20文字以内)', 'price' => 5000],
            
            // 丸形２段
            ['name' => '丸形２段', 'size' => 'なし', 'details' => '小：上12cm+下18cm', 'price' => 7300],
            ['name' => '丸形２段', 'size' => 'なし', 'details' => '大：上18cm+下24cm', 'price' => 11800],
            
            // アップルパイ
            ['name' => '【来店用】アップルパイ', 'size' => '6号', 'details' => '18cm：メッセージなし', 'price' => 3000],
            ['name' => '【来店用】アップルパイ', 'size' => '6号', 'details' => '18cm：HappyBirthday金プレート(+100円)', 'price' => 3100],
            ['name' => '【来店用】アップルパイ', 'size' => 'なし', 'details' => '18cm：メッセージあり(+200円)20文字以内', 'price' => 3200],
            
            // フルーツロール
            ['name' => 'フルーツロール', 'size' => 'なし', 'details' => '約16cm：メッセージなし', 'price' => 1700],
            ['name' => 'フルーツロール', 'size' => 'なし', 'details' => '約16cm：HappyBirthday金プレート(+100円)', 'price' => 1800],
            ['name' => 'フルーツロール', 'size' => 'なし', 'details' => '約16cm：メッセージあり(+200円)20文字以内', 'price' => 1900],
            
            // プチケーキ
            ['name' => 'プチケーキ', 'size' => 'なし', 'details' => '5個入', 'price' => 900],
            ['name' => 'プチケーキ', 'size' => 'なし', 'details' => '10個入', 'price' => 1800],
            
            // ロイヤルチーズ
            ['name' => '【来店用】ロイヤルチーズ', 'size' => 'なし', 'details' => '4個入／冷凍', 'price' => 770],
            ['name' => '【来店用】ロイヤルチーズ', 'size' => 'なし', 'details' => '4個入／冷蔵', 'price' => 770],
            ['name' => '【来店用】ロイヤルチーズ', 'size' => 'なし', 'details' => '6個入／冷凍', 'price' => 1190],
            ['name' => '【来店用】ロイヤルチーズ', 'size' => 'なし', 'details' => '6個入／冷蔵', 'price' => 1190],
            ['name' => '【来店用】ロイヤルチーズ', 'size' => 'なし', 'details' => '14個入／冷凍', 'price' => 2740],
            ['name' => '【来店用】ロイヤルチーズ', 'size' => 'なし', 'details' => '14個入／冷蔵', 'price' => 2740],
            
            // 濃厚ショコラ
            ['name' => '【来店用】濃厚ショコラ', 'size' => 'なし', 'details' => '4個入／冷凍', 'price' => 770],
            ['name' => '【来店用】濃厚ショコラ', 'size' => 'なし', 'details' => '4個入／冷蔵', 'price' => 770],
            ['name' => '【来店用】濃厚ショコラ', 'size' => 'なし', 'details' => '6個入／冷凍', 'price' => 1190],
            ['name' => '【来店用】濃厚ショコラ', 'size' => 'なし', 'details' => '6個入／冷蔵', 'price' => 1190],
            ['name' => '【来店用】濃厚ショコラ', 'size' => 'なし', 'details' => '14個入／冷凍', 'price' => 2740],
            ['name' => '【来店用】濃厚ショコラ', 'size' => 'なし', 'details' => '14個入／冷蔵', 'price' => 2740],
            
            // ロイヤルチーズと濃厚ショコラのセット
            ['name' => '【来店用】ロイヤルチーズと濃厚ショコラのセット', 'size' => 'なし', 'details' => '6個入／冷凍', 'price' => 1190],
            ['name' => '【来店用】ロイヤルチーズと濃厚ショコラのセット', 'size' => 'なし', 'details' => '6個入／冷蔵', 'price' => 1190],
            ['name' => '【来店用】ロイヤルチーズと濃厚ショコラのセット', 'size' => 'なし', 'details' => '14個入／冷凍', 'price' => 2740],
            ['name' => '【来店用】ロイヤルチーズと濃厚ショコラのセット', 'size' => 'なし', 'details' => '14個入／冷蔵', 'price' => 2740],
        ];

        foreach ($westernProducts as $product) {
            Product::create([
                'name' => $product['name'],
                'name_kana' => $product['name'],
                'size' => $product['size'],
                'details' => $product['details'],
                'price' => $product['price'],
                'department_id' => $westernDept->id,
                'sales_status' => 'on_sale',
                'requires_packaging' => true,
                'decoration' => 'available',
            ]);
        }

        // アクセサリー部門の商品
        $accessoryProducts = [
            // クッキーメダル
            ['name' => 'クッキーメダル', 'size' => 'なし', 'details' => 'がんばったね', 'price' => 430],
            ['name' => 'クッキーメダル', 'size' => 'なし', 'details' => 'おつかれさま', 'price' => 430],
            ['name' => 'クッキーメダル', 'size' => 'なし', 'details' => 'おめでとう', 'price' => 430],
            ['name' => 'クッキーメダル', 'size' => 'なし', 'details' => 'ありがとう', 'price' => 430],
            ['name' => 'クッキーメダル', 'size' => 'なし', 'details' => 'だいすき', 'price' => 430],
            ['name' => 'クッキーメダル', 'size' => 'なし', 'details' => 'スマイル', 'price' => 430],
            
            // キャンドル
            ['name' => 'ストライプキャンドル５本入', 'size' => 'なし', 'details' => '小：約12cm', 'price' => 30],
            ['name' => 'ストライプキャンドル５本入', 'size' => 'なし', 'details' => '大：約18cm', 'price' => 50],
            ['name' => 'ナンバーキャンドル', 'size' => 'なし', 'details' => '備考欄にご希望のナンバーをご記入ください', 'price' => 120],
        ];

        foreach ($accessoryProducts as $product) {
            Product::create([
                'name' => $product['name'],
                'name_kana' => $product['name'],
                'size' => $product['size'],
                'details' => $product['details'],
                'price' => $product['price'],
                'department_id' => $accessoryDept->id,
                'sales_status' => 'on_sale',
                'requires_packaging' => false,
                'decoration' => 'unavailable',
            ]);
        }
    }
}
