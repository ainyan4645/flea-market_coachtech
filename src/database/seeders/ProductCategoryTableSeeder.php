<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
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
        // 実際に存在するカテゴリIDを取得
        $categoryIds = Category::pluck('id')->toArray();
        // カテゴリが存在しない場合はスキップ
        if (empty($categoryIds)) {
            return;
        }

        // 実際に存在する全商品を取得
        $products = Product::all();
        // 商品がない場合は何もしない
        if (Product::count() === 0) {
        return;
        }

        foreach ($products as $product) {
            // 各商品に2〜3カテゴリをランダムで紐付け
            $randomCategories = collect($categoryIds)
                ->shuffle()
                ->take(rand(2, 3))
                ->toArray();

            foreach ($randomCategories as $categoryId) {
                ProductCategory::create([
                    'product_id' => $product->id,
                    'category_id' => $categoryId,
                ]);
            }
        }
    }
}
