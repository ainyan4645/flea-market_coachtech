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
        User::create([
            'name' => '出品テストユーザー',
            'email' => 'sell@example.com',
            'password' => Hash::make('password'),
        ]);

        // 同時にProfile作成
        Profile::create([
            'user_id' => $user->id,
            'name' => $user->name, // 名前を一致させる
            'postal_code' => '100-0001',
            'address' => '東京都千代田区千代田1-1',
            'building' => '皇居前ビル',
        ]);
    }
}
