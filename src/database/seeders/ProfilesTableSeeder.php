<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        // UsersTableSeederで作成したユーザーを取得
        $user = User::where('email', 'sell@example.com')->first();

        if ($user) {
            Profile::create([
                'user_id' => $user->id,
                'name' => '出品テストユーザー',
                'postal_code' => '1000001',
                'address' => '東京都千代田区千代田1-1',
                'building' => '皇居前ビル',
            ]);
        }
    }
}
