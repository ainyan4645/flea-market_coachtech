<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // サンプル商品出品ユーザー
        $user1 = User::create([
            'name' => '出品テストユーザー',
            'email' => 'sell@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        // 同時にProfile作成
        Profile::create([
            'user_id' => $user1->id,
            'postal_code' => '100-0001',
            'address' => '東京都千代田区千代田1-1',
            'building' => '皇居前ビル',
        ]);

    // 機能確認用の一般ユーザー
        $user2 = User::create([
            'name' => 'テストユーザーA',
            'email' => 'testA@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        Profile::create([
            'user_id' => $user2->id,
            'postal_code' => '150-0001',
            'address' => '東京都渋谷区神宮前1-1',
            'building' => '神宮前ビル',
        ]);
    }
}
