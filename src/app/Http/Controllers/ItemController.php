<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Product;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;


class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend'); // タブ判定

        if ($tab === 'recommend') {
            $products = Product::all(); // おすすめ商品（全商品）
        } elseif ($tab === 'mylist' && auth()->check()) {
            $products = auth()->user()->myListProducts ?? collect(); // ユーザーのお気に入りリスト
        } else {
            $products = collect(); // 空コレクション
        }

        return view('item.index', compact('products', 'tab'));
    }

    // 商品詳細表示
    public function detail($id)
    {
        // $product = Product::findOrFail($id);
        $product = Product::with('categories')->findOrFail($id);
        $comments = $product->comments()->latest()->get(); // 新しい順
        return view('item.detail', compact('product', 'comments'));
    }

    // お気に入り機能
    public function favorite($id)
    {
        $user = Auth::user();

        // すでにお気に入りに入っているかチェック
        $like = Like::where('user_id', $user->id)
                    ->where('product_id', $id)
                    ->first();

        if ($like) {
            // 既存なら削除
            $like->delete();
        } else {
            // まだなら追加
            Like::create([
                'user_id' => $user->id,
                'product_id' => $id,
            ]);
        }

        return back(); // 前のページにリダイレクト
    }

    public function comment(CommentRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'body' => $request->body,
        ]);

        return back();
    }

    public function sell()
    {
        return view('item.sell');
    }
}
