<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Product;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'buyer_id' => User::factory(),      // 購入者
            'product_id' => Product::factory(), // 商品
            'payment_method' => $this->faker->randomElement(['convenience', 'credit']),
            'postal_code' => $this->faker->numerify('###-####'),
            'address' => $this->faker->address(),
            'building' => $this->faker->optional()->secondaryAddress(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
