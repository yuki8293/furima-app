<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;

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
}
