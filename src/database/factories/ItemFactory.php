<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;

class ItemFactory extends Factory
{
    // このFactoryが対応するモデル
    protected $model = Item::class;

    public function definition()
    {
        return [
            // 出品者
            'user_id' => User::factory(),

            // 商品名
            'name' => $this->faker->word(),

            // ブランド名
            'brand_name' => $this->faker->word(),

            // 商品説明
            'description' => $this->faker->sentence(),

            // 価格
            'price' => $this->faker->numberBetween(1000, 10000),

            // 商品状態
            'status' => '良好',

            // 画像
            'image' => 'dummy.jpg',
        ];
    }

}
