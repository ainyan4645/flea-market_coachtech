<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    // メールアドレスが入力されていない場合、バリデーションメッセージが表示される
    public function testEmailIsRequired()
    {
        $this->get('/login')->assertStatus(200);

        $this->withMiddleware();

        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/login');

        $response = $this->followRedirects($response);
        $response->assertSee('メールアドレスを入力してください');
    }

    // パスワードが入力されていない場合、バリデーションメッセージが表示される
    public function testPasswordIsRequired()
    {
        $this->get('/login')->assertStatus(200);

        $this->withMiddleware();

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $response->assertRedirect('/login');

        $response = $this->followRedirects($response);
        $response->assertSee('パスワードを入力してください');
    }

    // 入力情報が間違っている場合、バリデーションメッセージが表示される
    public function testInvalidCredentialsShowError()
    {
        $this->get('/login')->assertStatus(200);

        $this->withMiddleware();

        $response = $this->post('/login', [
            'email' => 'notfound@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect('/login');

        $response = $this->followRedirects($response);
        $response->assertSee('ログイン情報が登録されていません');
    }

    // 正しい情報が入力された場合、ログイン処理が実行される
    public function testLoginSucceedsWithValidCredentials()
    {
        $this->get('/login')->assertStatus(200);

        $this->withMiddleware();

        // ユーザーを事前に作成
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // 正しい情報でログイン
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // ログイン成功時にTOPページへ遷移
        $response->assertRedirect('/');

        // 認証されていることを確認
        $this->assertAuthenticatedAs($user);
    }
}
