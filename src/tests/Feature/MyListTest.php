<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Like;
use Tests\TestCase;

class MyListTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    // いいねした商品だけが表示される
    public function testShowsOnlyLikedItems()
    {
        $user = User::factory()->create();
        // 以後のリクエストをこのユーザーで認証済みとして実行
        $this->actingAs($user);

        // 商品を2つ作成
        $likedProduct = Product::factory()->create(['name' => 'Liked Product']);
        $notLikedProduct = Product::factory()->create(['name' => 'Not Liked Product']);

        // product1 にいいね
        Like::factory()->create([
            'user_id' => $user->id,
            'product_id' => $likedProduct->id,
        ]);

        // マイリストページへアクセス
        $response = $this->get('/?tab=mylist');

        // 検証
        $response->assertStatus(200);
        $response->assertSee('Liked Product');       // いいね商品が表示される
        $response->assertDontSee('Not Liked Product'); // いいねしてない商品は非表示
    }

    // 購入済み商品は「Sold」と表示される
    public function testSoldItemsShowSoldLabel()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // 購入済み商品
        $soldProduct = Product::factory()->sold()->create([
            'name' => 'Sold Product',
        ]);

        // いいね登録済み
        Like::factory()->create([
            'user_id' => $user->id,
            'product_id' => $soldProduct->id,
        ]);

        // マイリストページへアクセス
        $response = $this->get('/?tab=mylist');

        // 検証
        $response->assertStatus(200);
        $response->assertSee('Sold'); // 購入済み商品にSold表示
    }

    // 未認証の場合は何も表示されない
    public function testGuestSeesNoItems()
    {
        // ユーザーを作成し、ログインする
        $user = User::factory()->create();
        $this->actingAs($user);

        // 商品を2つ作成
        $likedProduct = Product::factory()->create(['name' => 'Liked Product']);
        $notLikedProduct = Product::factory()->create(['name' => 'Not Liked Product']);

        // 「Liked Product」をいいねする
        Like::factory()->create([
            'user_id' => $user->id,
            'product_id' => $likedProduct->id,
        ]);

        // ログアウトする
        auth()->logout();

        // ゲストとしてマイリストページにアクセス
        $response = $this->get('/?tab=mylist');

        // 検証
        $response->assertStatus(200);
        $response->assertDontSee('Liked Product');     // ログアウト後はいいね商品が表示されない
        $response->assertDontSee('Not Liked Product'); // 他の商品も非表示
    }
}
