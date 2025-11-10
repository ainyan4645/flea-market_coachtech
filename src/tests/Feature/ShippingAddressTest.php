<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Order;
use Tests\TestCase;

class ShippingAddressTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    // 送付先住所変更画面にて登録した住所が商品購入画面に反映されている
    public function testUpdatedAddressAppearsInPurchasePage()
    {
        // --- 準備 ---
        $user = User::factory()->create();
        Profile::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create(['is_sold' => false]);

        $this->actingAs($user);

        // --- 住所を更新 ---
        $updatedAddress = [
            'postal_code' => '999-9999',
            'address'     => '東京都テスト区サンプル町9-9-9',
            'building'    => 'テストハイツ999',
        ];

        $this->post(route('purchase.address.update', ['id' => $product->id]), $updatedAddress);

        // --- 商品購入画面を再表示 ---
        $response = $this->get(route('purchase.confirm', ['id' => $product->id]));

        // --- 表示内容確認 ---
        $response->assertStatus(200);
        $response->assertSee('〒 ' . $updatedAddress['postal_code']);
        $response->assertSee($updatedAddress['address']);
        $response->assertSee($updatedAddress['building']);
    }

    // 購入した商品に送付先住所が紐づいて登録される
    public function testPurchaseIsLinkedToShippingAddress()
    {
        // --- 準備 ---
        $user = User::factory()->create();
        Profile::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create(['is_sold' => false]);

        $this->actingAs($user);

        // --- 住所を一時更新 ---
        $updatedAddress = [
            'postal_code' => '555-5555',
            'address'     => '東京都中央区銀座5-5-5',
            'building'    => 'テストビル5F',
        ];

        $this->post(route('purchase.address.update', ['id' => $product->id]), $updatedAddress);

        // --- 購入 ---
        $response = $this->post(route('purchase.store'), [
            'buyer_id'       => $user->id,
            'product_id'     => $product->id,
            'payment_method' => 'credit',
            'postal_code'    => $updatedAddress['postal_code'],
            'address'        => $updatedAddress['address'],
            'building'       => $updatedAddress['building'],
        ]);

        // --- 購入処理確認 ---
        $response->assertRedirect('/');

        $this->assertDatabaseHas('orders', [
            'buyer_id'       => $user->id,
            'product_id'     => $product->id,
            'postal_code'    => $updatedAddress['postal_code'],
            'address'        => $updatedAddress['address'],
            'building'       => $updatedAddress['building'],
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_sold' => true,
        ]);
    }
}
