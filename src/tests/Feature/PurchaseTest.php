<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_purchase_an_item_and_status_is_updated()
    {
        // 出品ユーザーと購入ユーザー作成
        $seller = User::factory()->create();
        $buyer = User::factory()->create([
            'postcode' => '123-4567',
            'address' => '東京都テスト区1-1-1',
            'building' => 'テストビル101'
        ]);

        // 商品作成（出品者が所有）
        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => '購入テスト商品',
            'price' => 3000,
            'status' => '良好',
        ]);

        // 購入ユーザーでログイン
        $this->actingAs($buyer);

        // 商品購入画面にアクセス
        $response = $this->get("/purchase/{$item->id}");
        $response->assertStatus(200);
        $response->assertSee($buyer->address); // 住所が表示されているか確認

        // 「購入する」を押して購入
        $response = $this->post("/purchase/{$item->id}/complete", [
            'postcode' => $buyer->postcode,
            'address' => $buyer->address,
            'building' => $buyer->building,
            'payment_method' => 'credit_card',
        ]);
        $response->assertStatus(302);

        // 商品が購入済み（sold）になっているか確認
        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'status' => 'sold',
        ]);

        // プロフィール画面で購入商品が表示されているか確認
        $response = $this->get("/mypage");
        $response->assertStatus(200);
        $response->assertSee('購入テスト商品');
    }

    /** @test */
    public function user_can_select_payment_method()
    {
        $user = User::factory()->create([
            'postcode' => '123-4567',
            'address' => '東京都テスト区1-1-1',
            'building' => 'テストビル101'
        ]);
        $this->actingAs($user);

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '支払い方法テスト商品',
            'price' => 2000,
        ]);

        // 購入処理（支払い方法を選択）
        $paymentMethod = 'credit_card'; // 例
        $response = $this->post("/purchase/{$item->id}/complete", [
            'postcode' => $user->postcode,
            'address' => $user->address,
            'building' => $user->building,
            'payment_method' => $paymentMethod,
        ]);
        $response->assertStatus(302);

        // DBに選択内容が反映されているか確認
        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'payment_method' => $paymentMethod,
        ]);
    }

    /**
     * ユーザーが配送先住所を変更すると、
     * 商品購入画面に変更した住所が正しく表示されることを確認する
     */

    /** @test */
    public function user_can_update_shipping_address()
    {
        // ① ユーザー作成
        $user = User::factory()->create();

        // ② 商品作成
        $item = Item::factory()->create();

        // ③ ユーザーでログイン
        $this->actingAs($user);

        // ④ 配送先住所を変更する（住所変更画面からPOST）
        $this->post("/purchase/address/{$item->id}", [
            'postcode' => '111-1111',
            'address' => '東京都テスト区2-2-2',
            'building' => 'テストマンション202'
        ]);

        // ⑤ 商品購入画面を開く
        $response = $this->get("/purchase/{$item->id}");

        // ⑥ ページが正常に表示されるか確認
        $response->assertStatus(200);

        // ⑦ 変更した住所が購入画面に表示されているか確認
        $response->assertSee('東京都テスト区2-2-2');
    }

    /**
     * ユーザーが商品を購入したとき、
     * 選択している配送先住所が purchases テーブルに
     * 正しく保存されることを確認する
     */

    /** @test */
    public function purchased_item_has_shipping_address()
    {
        // ① 出品ユーザー作成
        $seller = User::factory()->create();

        // ② 購入ユーザー作成（住所付き）
        $buyer = User::factory()->create([
            'postcode' => '123-4567',
            'address' => '東京都テスト区1-1-1',
            'building' => 'テストビル101'
        ]);

        // ③ 商品作成
        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);

        // ④ 購入ユーザーでログイン
        $this->actingAs($buyer);

        // ⑤ 商品を購入
        $this->post("/purchase/{$item->id}/complete", [
            'payment_method' => 'credit_card',
            'postcode' => $buyer->postcode,
            'address' => $buyer->address,
            'building' => $buyer->building,
        ]);

        // ⑥ purchases テーブルに住所が保存されているか確認
        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'user_id' => $buyer->id,
            'postcode' => '123-4567',
            'address' => '東京都テスト区1-1-1',
            'building' => 'テストビル101',
        ]);
    }
}
