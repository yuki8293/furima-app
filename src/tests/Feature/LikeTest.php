<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    // いいねアイコンを押すといいねが登録される
    public function test_user_can_like_an_item()
    {
        // ユーザー作成
        $user = User::factory()->create();

        // 商品作成
        $item = Item::factory()->create();

        // ログイン
        $this->actingAs($user);

        // いいね処理
        $this->post('/item/' . $item->id . '/like');

        // DBに登録されているか確認
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    // いいねを再度押すと解除される
    public function test_user_can_unlike_an_item()
    {
        // ユーザー作成
        $user = User::factory()->create();

        // 商品作成
        $item = Item::factory()->create();

        // いいねを先に登録
        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // ログイン
        $this->actingAs($user);

        // 再度いいね押す（解除）
        $this->post('/item/' . $item->id . '/like');

        // DBから消えているか確認
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}
