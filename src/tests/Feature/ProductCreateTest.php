<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductCreateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    // 商品出品画面にて必要な情報が保存できること（カテゴリ、商品の状態、商品名、ブランド名、商品の説明、販売価格）
    public function testCanStoreProductInfo()
    {
        Storage::fake('public');

        // ユーザー作成
        $user = User::factory()->create();

        // カテゴリ作成
        $categories = Category::factory()->count(2)->create();

        // ダミーファイル作成
        $file = UploadedFile::fake()->create('product.jpg', 100); // 100KB

        // ログイン
        $this->actingAs($user);

        // POST送信
        $response = $this->post(route('sell.store'), [
            'image_path' => $file,
            'categories' => $categories->pluck('id')->toArray(),
            'condition'  => 'new',
            'name'       => 'テスト商品',
            'brand'      => 'テストブランド',
            'description'=> 'テスト商品の説明',
            'price'      => 1000,
        ]);

        // リダイレクト確認
        $response->assertRedirect(route('item.index'));

        // DBに保存されているか確認
        $this->assertDatabaseHas('products', [
            'user_id'  => $user->id,
            'condition'=> 'new',
            'name'     => 'テスト商品',
            'brand'    => 'テストブランド',
            'description'=> 'テスト商品の説明',
            'price'    => 1000,
        ]);

        $product = Product::first();

        // 画像が保存されているか確認
        Storage::disk('public')->assertExists('products/' . $file->hashName());

        // カテゴリが紐付いているか確認
        // カテゴリ紐付けも確認
        $productId = \App\Models\Product::first()->id;
        foreach ($categories as $category) {
            $this->assertDatabaseHas('product_category', [
                'product_id'  => $productId,
                'category_id' => $category->id,
            ]);
        }
    }
}
