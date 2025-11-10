<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    // 変更項目が初期値として過去設定されていること（プロフィール画像、ユーザー名、郵便番号、住所）
    public function testPrefillsPreviousUserData()
    {
        Storage::fake('public');

        // ユーザー作成
        $user = User::factory()->create([
            'name' => 'テストユーザー',
        ]);

        // プロフィール作成
        $profile = Profile::factory()->create([
            'user_id'     => $user->id,
            'profile_image' => 'profile.jpg',
            'postal_code' => '123-4567',
            'address'     => '東京都渋谷区',
            'building'    => 'ビル101',
        ]);

        // ログイン
        $this->actingAs($user);

        // プロフィール編集画面にアクセス
        $response = $this->get(route('mypage.edit'));

        $response->assertStatus(200);

        // ユーザー名が初期値として表示されている
        $response->assertSee('テストユーザー');

        // プロフィール画像が表示されている
        $response->assertSee($profile->profile_image);

        // 郵便番号、住所、建物名が初期値として表示されている
        $response->assertSee($profile->postal_code);
        $response->assertSee($profile->address);
        $response->assertSee($profile->building);
    }
}
