<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use Tests\TestCase;

class ItemDetailTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    // 商品詳細ページに必要な情報が表示される
    public function testDisplaysItemDetails()
    {
        // 商品作成
        $product = Product::factory()->create([
            'name' => 'Test Product',
            'brand' => 'Test Brand',
            'price' => 1000,
            'description' => '商品説明テスト',
            'is_sold' => false,
        ]);

        // カテゴリ作成・紐付け
        $category = Category::factory()->create(['name' => 'ファッション']);
        $product->categories()->attach($category->id);

        // コメント作成（3件）
        $commentUsers = User::factory()->count(3)->create();
        foreach ($commentUsers as $index => $user) {
            Comment::factory()->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'body' => "コメントテスト {$index}"
            ]);
        }

        // いいね作成（2件）
        $likeUsers = User::factory()->count(2)->create();
        foreach ($likeUsers as $user) {
            Like::factory()->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }

        $response = $this->get(route('item.detail', $product->id));

        $response->assertStatus(200);
        $response->assertSee('Test Product');
        $response->assertSee('Test Brand');
        $response->assertSee('¥1,000');
        $response->assertSee('商品説明テスト');
        $response->assertSee('ファッション');
        $response->assertSee($product->condition_label);

        // いいね数・コメント数（DB 上の件数とビューに表示されるか）
        $this->assertEquals(2, $product->likes()->count());
        $this->assertEquals(3, $product->comments()->count());
        $response->assertSee((string) $product->likes()->count());
        $response->assertSee((string) $product->comments()->count());
        // コメントユーザー名・内容
        foreach ($commentUsers as $index => $user) {
            $response->assertSee($user->name);
            $response->assertSee("コメントテスト {$index}");
        }
    }

    // 複数選択されたカテゴリが表示されているか
    public function testDisplaysMultipleCategories()
    {
        $product = Product::factory()->create();

        // 複数カテゴリ作成・紐付け
        $category1 = Category::factory()->create(['name' => 'ファッション']);
        $category2 = Category::factory()->create(['name' => '家電']);
        $product->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get(route('item.detail', $product->id));

        $response->assertStatus(200);
        $response->assertSee('ファッション');
        $response->assertSee('家電');
    }
}
