<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Like;
use Tests\TestCase;

class LikeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    // いいねアイコンを押下することによって、いいねした商品として登録することができる。
    public function testCanLikeItem()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        $response = $this->get(route('item.detail', $product->id));

        // 初回アクセス時はいいねなし
        $this->assertFalse($product->likes()->where('user_id', $user->id)->exists());
        $this->assertEquals(0, $product->likes()->count());

        // いいね押下（POST）
        $response = $this->post(route('product.favorite', $product->id));

        $response->assertStatus(302); // back() なのでリダイレクト

        $this->assertTrue($product->fresh()->likes()->where('user_id', $user->id)->exists());
        $this->assertEquals(1, $product->fresh()->likes()->count());
    }

    // 追加済みのアイコンは色が変化する
    public function testLikedIconChangesColor()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        // 初回アクセスで未いいね状態（星アイコン通常）
        $response = $this->get(route('item.detail', $product->id));
        $response->assertSee('img/星アイコン.png'); // 未いいね状態の画像確認

        // いいね押下
        $this->post(route('product.favorite', $product->id));

        // 再取得でいいね済み状態（星アイコン黄色）
        $response = $this->get(route('item.detail', $product->id));
        $response->assertSee('img/星アイコン_yellow.png'); // いいね済み状態の画像確認
    }

    // 再度いいねアイコンを押下することによって、いいねを解除することができる。
    public function testCanUnlikeItem()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        $response = $this->get(route('item.detail', $product->id));

        // 先にいいね登録
        Like::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->assertEquals(1, $product->likes()->count());

        // 再度いいね押下で解除
        $response = $this->post(route('product.favorite', $product->id));
        $response->assertStatus(302);

        $this->assertFalse($product->fresh()->likes()->where('user_id', $user->id)->exists());
        $this->assertEquals(0, $product->fresh()->likes()->count());
    }
}
