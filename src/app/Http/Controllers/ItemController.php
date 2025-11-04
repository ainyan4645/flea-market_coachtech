<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\CommentRequest;
use App\Models\Product;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend'); // タブ判定
        $keyword = $request->query('keyword');      // 検索キーワード取得

        if ($tab === 'recommend') {
            // おすすめ：全商品の中から検索
            $query = Product::query();

            // 🔽 自分が出品した商品を除外（ログイン時のみ）
            if (Auth::check()) {
                $query->where('user_id', '!=', Auth::id());
            }

            if ($keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            }

            $products = $query->get();

        } elseif ($tab === 'mylist' && auth()->check()) {
            // お気に入り商品の中から検索
            $user = auth()->user();

            // ユーザーのお気に入り商品IDを取得
            $myListIds = $user->myListProducts()->pluck('products.id');
            // ↑ myListProducts リレーションが Product モデルを返す想定

            $query = Product::whereIn('id', $myListIds);

            if ($keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            }

            $products = $query->get();


        } else {
            // 未ログインでmylistを開いた場合など
            $products = collect();
        }

        return view('item.index', compact('products', 'tab'));
    }


    // 商品詳細表示
    public function detail($id)
    {
        $product = Product::with('categories', 'likes', 'comments')->findOrFail($id);
        $isFavorite = false;
        if (Auth::check()) {
            $isFavorite = $product->likes()->where('user_id', Auth::id())->exists();
        }
        $comments = $product->comments()->latest()->get(); // 新しい順
        return view('item.detail', compact('product', 'isFavorite', 'comments'));
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
        $tempImage =session('temp_product_image');
        $categories = Category::all();

        return view('item.sell', compact('tempImage', 'categories'));
    }

    public function store(ExhibitionRequest $request) {
        // 画像保存
        $path = $request->file('image_path')->store('products', 'public');

        // DB保存
        $product = Product::create([
        'user_id' => auth()->id(),
        'image_path' => $path,
        'condition' => $request->condition,
        'name' => $request->name,
        'brand' => $request->brand,
        'description' => $request->description,
        'price' => $request->price,
    ]);

        // カテゴリ紐付け
        $product->categories()->sync($request->input('categories'));

        return redirect()->route('item.index');
    }
}
