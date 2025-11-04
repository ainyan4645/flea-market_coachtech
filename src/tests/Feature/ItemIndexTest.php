<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;


class ItemIndexTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\DatabaseSeeder::class);
    }

    /** @test */
    public function testCanFetchAllItems()
    {
        // 商品一覧ページにアクセス
        $response = $this->get('/');

        $response->assertStatus(200);

        // 商品名が一覧に含まれていることを確認
        $products = Product::all();
        foreach ($products as $product) {
            $response->assertSee($product->name);
        }
    }

    /** @test */
    public function testSoldItemsShowSoldLabel()
    {
        // is_sold = true の商品を取得
        $soldProduct = Product::where('is_sold', true)->first();

        // 商品一覧ページにアクセス
        $response = $this->get('/');

        $response->assertStatus(200);
        // 商品名とともに「Sold」ラベルが表示されていることを確認
        $response->assertSee($soldProduct->name);
        $response->assertSee('Sold');
    }

    /** @test */
    public function testOwnItemsAreHidden()
    {
        // Seederで登録済みの「出品者ユーザー」を取得
        $seller = User::where('email', 'sell@example.com')->first();

        // 念のため存在確認
        $this->assertNotNull($seller, 'Seederで出品者ユーザーが作成されていません。');

        // Seederで登録された商品の中から出品者の商品を取得
        $myProduct = Product::where('user_id', $seller->id)->first();

        $this->assertNotNull($myProduct, 'Seederで商品が作成されていません。');

        // 出品者としてログイン
        $this->actingAs($seller);

        // 商品一覧ページを取得
        $response = $this->get('/');

        // --- 検証 ---
        $response->assertStatus(200);
        // 出品者自身の商品は表示されないこと
        $response->assertDontSee($myProduct->name);
    }
}
