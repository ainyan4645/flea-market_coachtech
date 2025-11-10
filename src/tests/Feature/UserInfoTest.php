<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Order;
use Tests\TestCase;

class UserInfoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    // 必要な情報が取得できる（プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧）
    public function testCanFetchUserInfo()
    {
        // ユーザー作成
        $user = User::factory()->create();

        // プロフィール作成
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
            'profile_image' => 'profile.jpg',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => '渋谷マンション101',
        ]);

        // 出品商品作成
        $sellProducts = Product::factory()->count(2)->create([
            'user_id' => $user->id,
        ]);

        // 購入商品作成
        $buyProducts = Product::factory()->count(2)->create();
        foreach ($buyProducts as $product) {
            Order::factory()->create([
                'buyer_id' => $user->id,
                'product_id' => $product->id,
                'payment_method' => 'convenience',
                'postal_code' => $profile->postal_code,
                'address' => $profile->address,
                'building' => $profile->building,
            ]);
        }

        // ログイン
        $this->actingAs($user);

        // 出品タブページ確認
        $response = $this->get(route('mypage', ['page' => 'sell']));
        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertSee('profile.jpg');
        foreach ($sellProducts as $product) {
            $response->assertSee($product->name);
        }

        // 購入タブページ確認
        $response = $this->get(route('mypage', ['page' => 'buy']));
        $response->assertStatus(200);
        foreach ($buyProducts as $product) {
            $response->assertSee($product->name);
        }
    }
}
