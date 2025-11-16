<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Profile;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    // 「購入する」ボタンを押下すると購入が完了する
    public function testCanPurchaseItem()
    {
        // ユーザー作成 + プロフィール作成
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user)->create();

        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post(route('purchase.store'), [
            'buyer_id' => $user->id,
            'product_id' => $product->id,
            'payment_method' => 'credit',
            'postal_code' => $profile->postal_code,
            'address' => $profile->address,
            'building' => $profile->building,
        ]);

        $response->assertStatus(302); // リダイレクト確認
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_sold' => true,
        ]);
        $this->assertDatabaseHas('orders', [
            'buyer_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    // 購入した商品は商品一覧画面にて「sold」と表示される
    public function testPurchasedItemShowsSoldLabel()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user)->create();

        $product = Product::factory()->create(['is_sold' => false]);

        // 購入処理
        $this->actingAs($user)->post(route('purchase.store'), [
            'buyer_id' => $user->id,
            'product_id' => $product->id,
            'payment_method' => 'credit',
            'postal_code' => $profile->postal_code,
            'address' => $profile->address,
            'building' => $profile->building,
        ]);

        // 商品一覧表示
        $response = $this->get(route('item.index'));
        $response->assertStatus(200);
        $response->assertSee('Sold'); // Soldラベルを確認
    }

    // 「プロフィール/購入した商品一覧」に追加されている
    public function testPurchasedItemAppearsInProfile()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user)->create();

        $product = Product::factory()->create(['is_sold' => false]);

        // 購入処理
        $this->actingAs($user)->post(route('purchase.store'), [
            'buyer_id' => $user->id,
            'product_id' => $product->id,
            'payment_method' => 'credit',
            'postal_code' => $profile->postal_code,
            'address' => $profile->address,
            'building' => $profile->building,
        ]);

        // プロフィール購入タブ
        $response = $this->get('/mypage?page=buy');
        $response->assertStatus(200);
        $response->assertSee($product->name); // 購入商品が表示される
    }
}
