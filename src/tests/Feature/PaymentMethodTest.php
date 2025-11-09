<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    // 小計画面で変更が反映される
    public function testPaymentMethodUpdatesSubtotal()
    {
        // ユーザー作成・ログイン
        $user = User::factory()->create();
        $this->actingAs($user);

        // 商品作成
        $product = Product::factory()->create();

        // 支払い方法を選択（コンビニ支払い）
        $response = $this->post(route('purchase.updatePayment', ['id' => $product->id]), [
            'payment_method' => 'convenience',
        ]);

        // リダイレクト確認
        $response->assertRedirect(route('purchase.confirm', ['id' => $product->id]));

        // confirm画面にアクセス
        $response = $this->get(route('purchase.confirm', ['id' => $product->id]));

        // 小計画面に選択した支払い方法が反映されているか確認
        $response->assertSee('コンビニ支払い');

        // 支払い方法をカードに変更して再確認
        $response = $this->post(route('purchase.updatePayment', ['id' => $product->id]), [
            'payment_method' => 'credit',
        ]);

        $response->assertRedirect(route('purchase.confirm', ['id' => $product->id]));

        $response = $this->get(route('purchase.confirm', ['id' => $product->id]));
        $response->assertSee('カード支払い');
    }

}
