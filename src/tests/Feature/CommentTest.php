<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use Tests\TestCase;

class CommentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    // ログイン済みユーザーはコメント送信できる
    public function testLoggedInUserCanPostComment()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        $commentData = ['body' => 'テストコメント'];

        $response = $this->post(route('item.comment', $product->id), $commentData);

        $response->assertStatus(302); // back()でリダイレクトされる
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'body' => 'テストコメント'
        ]);
        $this->assertEquals(1, $product->fresh()->comments()->count());
    }

    // ログイン前のユーザーはコメントを送信できない
    public function testGuestCannotPostComment()
    {
        $product = Product::factory()->create();

        $commentData = ['body' => 'ゲストコメント'];

        $response = $this->post(route('item.comment', $product->id), $commentData);

        $response->assertRedirect(route('login')); // ログイン画面にリダイレクトされる
        $this->assertDatabaseMissing('comments', [
            'product_id' => $product->id,
            'body' => 'ゲストコメント'
        ]);
    }

    // コメントが入力されていない場合、バリデーションメッセージが表示される
    public function testCommentIsRequired()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        $response = $this->post(route('item.comment', $product->id), ['body' => '']);

        $response->assertSessionHasErrors([
            'body' => 'コメントを入力してください',
        ]);
        $this->assertEquals(0, $product->fresh()->comments()->count());
    }

    // コメントが255字以上の場合、バリデーションメッセージが表示される
    public function testCommentTooLong()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        $longComment = str_repeat('a', 256); // 256文字

        $response = $this->post(route('item.comment', $product->id), ['body' => $longComment]);

        $response->assertSessionHasErrors([
            'body' => 'コメントは255文字以内で入力してください',
        ]);
        $this->assertEquals(0, $product->fresh()->comments()->count());
    }
}
