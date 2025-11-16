<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class MypageController extends Controller
{
    public function mypageEdit() {
        $user = auth()->user();
        $profile = $user->profile;

        return view('mypage.mypage_edit', compact('user', 'profile'));
    }

    public function update(ProfileRequest $request) {
        $user = Auth::user();
        $profile = Profile::firstOrNew(['user_id' => $user->id]);;

        // 画像アップロード処理
        if ($request->hasFile('profile_image')) {
            // 既存画像を削除（任意）
            if ($profile->profile_image && Storage::disk('public')->exists($profile->profile_image)) {
                Storage::disk('public')->delete($profile->profile_image);
            }

            // 新しい画像を保存
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $profile->profile_image = $path;
        }

        // 各種プロフィール項目保存
        $profile->fill($request->only(['postal_code', 'address', 'building']));
        $user->name = $request->input('name', $user->name);

        $profile->save();
        $user->save();

        return redirect('/');
    }

    public function mypage(Request $request)
    {
        $user = Auth::user();

        // クエリパラメータ page の値を取得（デフォルト：sell）
        $page = $request->query('page', 'sell');

        // タブごとの商品取得
        if ($page === 'buy') {
            // 購入した商品
            $products = Product::whereIn('id', function($query) use ($user) {
                $query->select('product_id') ->from('orders') ->where('buyer_id', $user->id);
            })->get();
        } else {
            // 出品した商品
            $products = Product::where('user_id', $user->id)->get();
        }

        // ビューへ渡す
        return view('mypage.mypage', compact('user', 'products'));
    }
}
