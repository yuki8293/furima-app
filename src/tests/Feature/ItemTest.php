<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    // 全商品を取得できるテスト
    public function test_all_items_are_displayed()
    {
        // テスト用の商品を3つ作成
        $items = Item::factory()->count(3)->create();

        // 商品一覧ページにアクセス
        $response = $this->get('/');

        // ステータスコード200を確認
        $response->assertStatus(200);

        // 作成した商品がすべて表示されているか確認
        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
    }

    // 購入済み商品は「Sold」と表示される
    public function test_sold_label_is_displayed_for_purchased_items()
    {
        // ユーザー作成
        $user = User::factory()->create();

        // 商品を作成
        $item = Item::factory()->create();

        // 購入済み状態にする
        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // 商品一覧ページにアクセス
        $response = $this->get('/');

        // Soldが表示されているか確認
        $response->assertSee('Sold');
    }

    // 自分が出品した商品は表示されない
    public function test_user_cannot_see_own_items_in_list()
    {
        // ログインユーザー作成
        $user = User::factory()->create();

        // 自分の商品
        $myItem = Item::factory()->create([
            'user_id' => $user->id,
        ]);

        // 他人の商品
        $otherItem = Item::factory()->create();

        // ログイン状態を作る
        $this->actingAs($user);

        // 商品一覧ページ
        $response = $this->get('/');

        // 自分の商品は表示されない
        $response->assertDontSee($myItem->name);

        // 他人の商品は表示される
        $response->assertSee($otherItem->name);
    }

    // 商品詳細ページに必要な情報が表示される
    public function test_item_detail_page_displays_all_information()
    {
        // ユーザー作成
        $user = User::factory()->create();

        // 商品作成
        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'price' => 1000,
            'description' => 'テスト商品の説明',
            'status' => '良好',
        ]);

        // コメント作成
        Comment::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'テストコメント',
        ]);

        // 商品詳細ページアクセス
        $response = $this->get('/item/' . $item->id);

        // 商品情報が表示されているか確認
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('1,000');
        $response->assertSee('テスト商品の説明');

        // コメント情報確認
        $response->assertSee('テストコメント');
    }

    // 複数選択されたカテゴリが表示される
    public function test_multiple_categories_are_displayed_on_item_detail_page()
    {
        // 商品作成
        $item = Item::factory()->create();

        // カテゴリ作成
        $category1 = Category::factory()->create([
            'name' => '家電'
        ]);

        $category2 = Category::factory()->create([
            'name' => 'ゲーム'
        ]);

        // 商品にカテゴリ紐付け
        $item->categories()->attach([
            $category1->id,
            $category2->id
        ]);

        // 商品詳細ページアクセス
        $response = $this->get('/item/' . $item->id);

        // カテゴリ表示確認
        $response->assertSee('家電');
        $response->assertSee('ゲーム');
    }

    /**
     * ユーザーが商品出品画面で必要な情報を入力すると、
     * 商品情報（カテゴリ、商品の状態、商品名、ブランド名、商品の説明、販売価格）
     * が正しく保存されることを確認する
     */
    public function test_user_can_create_item_with_required_fields()
    {
        // ユーザー作成
        $user = User::factory()->create();

        // カテゴリ作成
        $category = Category::factory()->create([
            'name' => '家電'
        ]);

        // ログイン
        $this->actingAs($user);

        // 出品処理
        $response = $this->post('/sell', [
            'name' => '出品テスト商品',
            'brand_name' => 'テストブランド',
            'price' => 5000,
            'description' => 'テスト商品の説明',
            'status' => '良好',
            'category_id' => [$category->id],
            'image' => \Illuminate\Http\UploadedFile::fake()->image('test.jpg'), // 画像必須
        ]);

        // リダイレクト確認
        $response->assertStatus(302);

        // DBに保存されているか確認
        $this->assertDatabaseHas('items', [
            'name' => '出品テスト商品',
            'brand_name' => 'テストブランド',
            'price' => 5000,
            'description' => 'テスト商品の説明',
            'status' => '良好',
        ]);
    }
}
