<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(), // 自動でユーザーも作成
            'profile_image' => 'default.png', // デフォルト画像
            'name' => $this->faker->name,
            'postal_code' => $this->faker->numerify('###-####'),
            'address' => $this->faker->address,
            'building' => $this->faker->optional()->secondaryAddress(),
        ];
    }
}
