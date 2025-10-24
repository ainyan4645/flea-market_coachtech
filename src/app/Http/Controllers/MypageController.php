<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Order;

class MypageController extends Controller
{
    public function mypageEdit() {
        $user = auth()->user();
        $profile = $user->profile;
        $tempImage = session('temp_image');

        return view('mypage.mypage_edit', compact('profile', 'tempImage'));
    }

    public function uploadTemp(Request $request) {
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('tmp', 'public');
            session(['temp_image' => $path]);
        }

        return redirect()->route('mypage.edit');
    }

    public function update(ProfileRequest $request) {
        $user = Auth::user();
        $profile = Profile::firstOrNew(['user_id' => $user->id]);;

        // 一時画像がある場合、本保存場所に移動
        if (session()->has('temp_image')) {
            $tempPath = session('temp_image');
            $filename = basename($tempPath);
            $newPath = 'profile_images/' . $filename;

            Storage::disk('public')->move($tempPath, $newPath);

            $profile->profile_image = $newPath;
            session()->forget('temp_image');
        }

        // 各種プロフィール項目保存
        $profile->fill($request->only(['postal_code', 'address', 'building']));
        $profile->name = $request->input('name');
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
