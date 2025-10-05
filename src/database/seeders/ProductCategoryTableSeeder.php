<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 商品数・カテゴリ数を想定
        $productCount = 10;
        $categoryCount = 14;

        for ($productId = 1; $productId <= $productCount; $productId++) {
            // 各商品に2〜3カテゴリをランダムで紐付け
            $randomCategories = collect(range(1, $categoryCount))
                ->shuffle()
                ->take(rand(2, 3))
                ->toArray();

            foreach ($randomCategories as $categoryId) {
                ProductCategory::create([
                    'product_id' => $productId,
                    'category_id' => $categoryId,
                ]);
            }
        }
    }
}
