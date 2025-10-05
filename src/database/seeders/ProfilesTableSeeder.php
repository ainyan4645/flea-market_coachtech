<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::create([
            'user_id' => 1, // UsersTableSeederで作成したユーザーに紐付け
            'name' => '出品テストユーザー',
            'postal_code' => '1000001',
            'address' => '東京都千代田区千代田1-1',
            'building' => '皇居前ビル',
        ]);
    }
}
