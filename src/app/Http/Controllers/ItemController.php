<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend'); // タブ判定

        if ($tab === 'recommend') {
            $products = Product::all(); // おすすめ商品（全商品）
        } elseif ($tab === 'mylist' && auth()->check()) {
            $products = auth()->user()->myListProducts; // ユーザーのお気に入りリスト
        } else {
            $products = collect(); // 空コレクション
        }

        return view('item.index', compact('products', 'tab'));
    }

    // 商品詳細表示
    public function detail($id)
    {
        // Eloquentで対象の商品を取得
        $item = Item::findOrFail($id);

        return view('items.detail', compact('item'));
    }

    public function sell()
    {
        return view('item.sell');
    }
}
