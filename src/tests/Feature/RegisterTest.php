<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    // 名前未入力
    public function test_name_is_required()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $response->assertSessionHasErrors('name');
    }

    // メール未入力
    public function test_email_is_required()
    {
        $response = $this->post('/register', [
            'name' => 'テスト',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $response->assertSessionHasErrors('email');
    }

    // パスワード未入力
    public function test_password_is_required()
    {
        $response = $this->post('/register', [
            'name' => 'テスト',
            'email' => 'test@test.com',
            'password' => '',
            'password_confirmation' => ''
        ]);

        $response->assertSessionHasErrors('password');
    }

    // パスワード8文字未満
    public function test_password_must_be_8_characters()
    {
        $response = $this->post('/register', [
            'name' => 'テスト',
            'email' => 'test@test.com',
            'password' => '1234567',
            'password_confirmation' => '1234567'
        ]);

        $response->assertSessionHasErrors('password');
    }

    // パスワード不一致
    public function test_password_confirmation_must_match()
    {
        $response = $this->post('/register', [
            'name' => 'テスト',
            'email' => 'test@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password456'
        ]);

        $response->assertSessionHasErrors('password');
    }

    // 正常登録
    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'テスト',
            'email' => 'test@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $response->assertRedirect('/mypage/profile');
    }
}
