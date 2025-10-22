<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;

class MypageController extends Controller
{
    public function mypageEdit() {
        $profile = Profile::where('user_id', Auth::id())->first();
        return view('mypage.mypage_edit', compact('profile'));
    }

    public function update(ProfileRequest $request) {
        $profile = Profile::firstOrNew(['user_id' => Auth::id()]);

        $profile->name = $request->name;
        $profile->postal_code = $request->postal_code;
        $profile->address = $request->address;
        $profile->building = $request->building;

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $profile->profile_image = $path;
        }

        $profile->save();

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
