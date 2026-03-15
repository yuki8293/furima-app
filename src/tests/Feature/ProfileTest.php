<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ユーザーがプロフィールページを開いたとき、
     * ユーザー名と出品した商品が表示されることを確認
     */
    /** @test */
    public function user_profile_information_is_displayed()
    {
        // ① ユーザー作成(プロフィール画像も付ける)
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'icon' => 'test.png'
        ]);

        // ② 出品商品作成
        $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => 'テスト商品'
        ]);

        // ③ ログイン
        $this->actingAs($user);

        // ④ プロフィールページを開く
        $response = $this->get('/mypage?tab=sell');

        // ⑤ ページが正常に表示されるか確認
        $response->assertStatus(200);

        // ⑥ ユーザー名が表示されているか確認
        $response->assertSee('テストユーザー');

        // ⑦ 出品商品が表示されているか確認
        $response->assertSee('テスト商品');

        // ⑧ プロフィール画像のパスが表示されているか確認
        $response->assertSee('test.png');
    }

    /**
 * ユーザーが購入した商品がプロフィールページに表示されることを確認
 */

/** @test */
public function purchased_items_are_displayed_on_profile()
{
    // ① 出品ユーザー作成
    $seller = User::factory()->create();

    // ② 購入ユーザー作成
    $buyer = User::factory()->create();

    // ③ 商品作成
    $item = Item::factory()->create([
        'user_id' => $seller->id,
        'name' => '購入された商品'
    ]);

    // ④ 購入データ作成
    \App\Models\Purchase::create([
        'user_id' => $buyer->id,
        'item_id' => $item->id,
        'payment_method' => 'credit_card'
    ]);

    // ⑤ 購入ユーザーでログイン
    $this->actingAs($buyer);

    // ⑥ プロフィールページを開く
    $response = $this->get('/mypage');

    // ⑦ ページ表示確認
    $response->assertStatus(200);

    // ⑧ 購入した商品が表示されているか確認
    $response->assertSee('購入された商品');
}
}
