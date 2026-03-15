<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログイン済みユーザーはコメント送信できる
     */
    public function test_logged_in_user_can_submit_comment()
    {
        // ユーザーと商品を作成
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // ログイン状態を作る
        $this->actingAs($user);

        // コメント送信
        $response = $this->post("/item/{$item->id}/comment", [
            'comment' => 'テストコメントです'
        ]);

        // 正常リダイレクトを確認
        $response->assertStatus(302);

        // コメントがDBに保存されていることを確認
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'テストコメントです'
        ]);
    }

    /**
     * 未ログインユーザーはコメント送信できない
     */
    public function test_guest_cannot_submit_comment()
    {
        $item = Item::factory()->create();

        // 未ログインでコメント送信
        $response = $this->post("/item/{$item->id}/comment", [
            'comment' => 'ゲストコメント'
        ]);

        // リダイレクト（ログインページなど）を確認
        $response->assertStatus(302);

        // DBに保存されていないことを確認
        $this->assertDatabaseMissing('comments', [
            'comment' => 'ゲストコメント'
        ]);
    }

    /**
     * コメントが未入力の場合、バリデーションエラー
     */
    public function test_comment_is_required()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/item/{$item->id}/comment", [
            'comment' => ''
        ]);

        // セッションにエラーがあることを確認
        $response->assertSessionHasErrors('comment');
    }

    /**
     * コメントが255文字を超える場合、バリデーションエラー
     */
    public function test_comment_max_length()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $longComment = str_repeat('あ', 256); // 256文字

        $response = $this->post("/item/{$item->id}/comment", [
            'comment' => $longComment
        ]);

        $response->assertSessionHasErrors('comment');
    }
}
