<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'image_path' => 'products/sample.jpg', // ダミー画像パス
            'condition' => $this->faker->randomElement(['new', 'good', 'used', 'bad']),
            'name' => $this->faker->words(2, true), // 例: "Wooden Chair"
            'brand' => $this->faker->company(), // ランダムブランド
            'description' => $this->faker->sentence(10),
            'price' => $this->faker->numberBetween(1000, 20000),
            'is_sold' => false, // デフォルトで未販売
        ];
    }

    // 売却済み状態の商品を作成する state
    public function sold()
    {
        return $this->state(fn () => ['is_sold' => true]);
    }
}
