<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    // 商品名で部分一致検索ができる
    public function test_items_can_be_searched_by_partial_name()
    {
        // テスト用の商品作成
        $item1 = Item::factory()->create([
            'name' => 'Apple'
        ]);

        $item2 = Item::factory()->create([
            'name' => 'Banana'
        ]);

        // 検索キーワード「App」で検索
        $response = $this->get('/?keyword=App');

        // Appleは表示される
        $response->assertSee('Apple');

        // Bananaは表示されない
        $response->assertDontSee('Banana');
    }

    /**
     * 検索キーワードがマイリストページでも保持されているか確認
     */
    public function test_search_keyword_is_kept_when_switching_to_mylist()
    {
        // ユーザーを作成
        $user = User::factory()->create();

        // 商品を2つ作成
        $item1 = Item::factory()->create([
            'name' => 'Apple'
        ]);

        $item2 = Item::factory()->create([
            'name' => 'Banana'
        ]);

        // ユーザーでログイン
        $this->actingAs($user);

        // ① ホームページで「App」というキーワードで検索
        $response = $this->get('/?keyword=App');

        // Appleは表示される
        $response->assertSee('Apple');

        // Bananaは表示されない
        $response->assertDontSee('Banana');

        // ② マイリストページへ遷移（検索キーワードを保持した状態）
        $response = $this->get('/?tab=mylist&keyword=App');

        // ③ 検索キーワードが保持されているか確認
        $response->assertSee('App');
    }
}
