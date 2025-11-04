<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    /** @test */
    public function testUserCanLogout()
    {
        // テスト用ユーザーを作成
        $user = User::factory()->create([
            'email' => 'logout@example.com',
            'password' => bcrypt('password123'),
        ]);

        // ログイン状態にする
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        // ログアウトリクエストを送る
        $response = $this->post('/logout');

        // ログアウト後はTOPページにリダイレクト
        $response->assertRedirect('/');

        // 認証が解除されていることを確認
        $this->assertGuest();
    }
}
