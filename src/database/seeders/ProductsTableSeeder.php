<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'user_id' => 1,   // 出品テストユーザー
                'image_path' => 'products/seeding/ArmaniMensClock.jpg',
                'condition' => 1,   // 1:良好,2:目立った傷や汚れなし,3:やや傷や汚れあり,4:状態が悪い
                'name' => '腕時計',
                'brand' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'price' => 15000,
                'is_sold' => false,
            ],
            [
                'user_id' => 1,
                'image_path' => 'products/seeding/HDDHardDisk.jpg',
                'condition' => 2,
                'name' => 'HDD',
                'brand' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'price' => 5000,
                'is_sold' => false,
            ],
            [
                'user_id' => 1,
                'image_path' => 'products/seeding/Onion.jpg',
                'condition' => 3,
                'name' => '玉ねぎ3束',
                'brand' => 'なし',
                'description' => '新鮮な玉ねぎ3束のセット',
                'price' => 300,
                'is_sold' => false,
            ],
            [
                'user_id' => 1,
                'image_path' => 'products/seeding/LeatherShoes.jpg',
                'condition' => 4,
                'name' => '革靴',
                'brand' => '',
                'description' => 'クラシックなデザインの革靴',
                'price' => 4000,
                'is_sold' => false,
            ],
            [
                'user_id' => 1,
                'image_path' => 'products/seeding/notePC.jpg',
                'condition' => 1,
                'name' => 'ノートPC',
                'brand' => '',
                'description' => '高性能なノートパソコン',
                'price' => 45000,
                'is_sold' => false,
            ],
            [
                'user_id' => 1,
                'image_path' => 'products/seeding/MusicMic.jpg',
                'condition' => 2,
                'name' => 'マイク',
                'brand' => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'price' => 8000,
                'is_sold' => false,
            ],
            [
                'user_id' => 1,
                'image_path' => 'products/seeding/FashionBag.jpg',
                'condition' => 3,
                'name' => 'ショルダーバッグ',
                'brand' => '',
                'description' => 'おしゃれなショルダーバッグ',
                'price' => 3500,
                'is_sold' => false,
            ],
            [
                'user_id' => 1,
                'image_path' => 'products/seeding/TumblerSouvenir.jpg',
                'condition' => 4,
                'name' => 'タンブラー',
                'brand' => 'なし',
                'description' => '使いやすいタンブラー',
                'price' => 500,
                'is_sold' => false,
            ],
            [
                'user_id' => 1,
                'image_path' => 'products/seeding/CoffeeGrinder.jpg',
                'condition' => 1,
                'name' => 'コーヒーミル',
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'price' => 4000,
                'is_sold' => false,
            ],
            [
                'user_id' => 1,
                'image_path' => 'products/seeding/MakeUpSet.jpg',
                'condition' => 2,
                'name' => 'メイクセット',
                'brand' => '',
                'description' => '便利なメイクアップセット',
                'price' => 2500,
                'is_sold' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
