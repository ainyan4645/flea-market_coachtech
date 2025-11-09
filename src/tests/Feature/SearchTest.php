<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Like;
use Tests\TestCase;

class SearchTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    // 商品名で部分一致検索ができる
    public function testCanSearchByName()
    {
        // 検索対象データを準備
        Product::factory()->create(['name' => 'Apple Watch']);
        Product::factory()->create(['name' => 'Samsung Phone']);

        // 検索実行（"Apple" を含む商品名を検索）
        $response = $this->get('/?tab=recommend&keyword=Apple');

        // 結果確認
        $response->assertStatus(200);
        $response->assertSee('Apple Watch');
        $response->assertDontSee('Samsung Phone');
    }

    // 検索状態がマイリストでも保持されている
    public function testSearchStatePersistsInMyList()
    {
        // ユーザー作成＆ログイン
        $user = User::factory()->create();
        $this->actingAs($user);

        // 商品一覧ページにアクセス
        $response = $this->get('/');

        // 商品データ
        $product1 = Product::factory()->create(['name' => 'Nike Shoes']);
        $product2 = Product::factory()->create(['name' => 'Adidas Jacket']);

        // 両方をお気に入り登録
        Like::factory()->create(['user_id' => $user->id, 'product_id' => $product1->id]);
        Like::factory()->create(['user_id' => $user->id, 'product_id' => $product2->id]);

        // 「Nike」を検索したと仮定
        $response = $this->get('/?tab=recommend&keyword=Nike');

        // ホームでの検索結果確認
        $response->assertStatus(200);
        $response->assertSee('Nike Shoes');
        $response->assertDontSee('Adidas Jacket');

        // マイリストでも同じキーワードでアクセス
        $response = $this->get('/?tab=mylist&keyword=Nike');

        // 検索キーワードが維持されているか確認
        $response->assertStatus(200);
        $response->assertSee('Nike Shoes');
        $response->assertDontSee('Adidas Jacket');
    }
}
