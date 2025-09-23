<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return view('item.index');
    }

    // 商品詳細表示
    public function detail($id)
    {
        // Eloquentで対象の商品を取得
        $item = Item::findOrFail($id);

        return view('items.detail', compact('item'));
    }
}
