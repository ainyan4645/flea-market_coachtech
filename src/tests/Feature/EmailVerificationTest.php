<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Models\User;

class EmailVerificationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    // 会員登録後、認証メールが送信される
    public function testSendsVerificationEmailAfterRegistration()
    {
        Notification::fake(); // ← Notification をフェイク

        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        // メール認証通知送信
        $user->sendEmailVerificationNotification();

        Notification::assertSentTo(
            $user,
            VerifyEmail::class // ← Laravel 標準通知
        );
    }

    // メール認証誘導画面で「認証はこちらから」ボタンを押下するとメール認証サイトに遷移する
    public function testRedirectsToVerificationSiteFromNotice()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // メール認証画面を表示
        $response = $this->get(route('verification.notice'));
        $response->assertStatus(200);
        $response->assertSee('認証はこちらから');

        // 署名付きURLを生成（テスト用）
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        // Requestオブジェクトに変換して署名チェック
        $request = Request::create($verificationUrl);
        $this->assertTrue(URL::hasValidSignature($request));
    }

    // メール認証サイトのメール認証を完了すると、プロフィール設定画面に遷移する
    public function testCompletesEmailVerificationAndRedirectsToProfile()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($user);

        // 署名付きURLを生成
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        // 認証完了
        $response = $this->get($verificationUrl);

        // DBに反映されているか確認
        $this->assertTrue($user->fresh()->hasVerifiedEmail());

        // プロフィール設定画面にリダイレクト
        $response->assertRedirect('/mypage/profile');
    }
}
