<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use App\Models\Purchase;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    // いいねした商品だけが表示される
    public function test_only_liked_items_are_displayed_in_mylist()
    {
        // ユーザーを作成
        $user = User::factory()->create();

        // 商品を2つ作成
        $likedItem = Item::factory()->create();
        $notLikedItem = Item::factory()->create();

        // 1つの商品にいいねを登録
        Like::create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        // ユーザーでログイン
        $this->actingAs($user);

        // マイリストページを開く
        $response = $this->get('/?tab=mylist');

        // いいねした商品が表示される
        $response->assertSee($likedItem->name);

        // いいねしていない商品は表示されない
        $response->assertDontSee($notLikedItem->name);
    }

    // 購入済み商品は「Sold」と表示される
    public function test_sold_label_is_displayed_for_purchased_items_in_mylist()
    {
        // ユーザー作成
        $user = User::factory()->create();

        // 商品作成
        $item = Item::factory()->create();

        // 商品にいいねを登録
        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // 商品を購入済みにする
        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // ユーザーでログイン
        $this->actingAs($user);

        // マイリストページを開く
        $response = $this->get('/?tab=mylist');

        // 購入済み商品に「Sold」が表示される
        $response->assertSee('Sold');
    }

    // 未認証の場合は何も表示されない
    public function test_guest_cannot_see_items_in_mylist()
    {
        // 商品作成
        $item = Item::factory()->create();

        // マイリストページを開く（未ログイン）
        $response = $this->get('/?tab=mylist');

        // 商品は表示されない
        $response->assertDontSee($item->name);
    }
}
