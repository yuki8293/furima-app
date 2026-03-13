<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    // ログアウトができることを確認するテスト
    public function test_user_can_logout()
    {
        // テスト用ユーザーを作成
        $user = User::factory()->create();

        // 作成したユーザーでログイン状態を作る
        $response = $this->actingAs($user)->post('/logout');

        // ログアウト後トップページにリダイレクトされることを確認
        $response->assertRedirect('/');

        // ログアウト状態（未認証）になっていることを確認
        $this->assertGuest();
    }
}
