<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function confirm($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $user = Auth::user()->load('profile');

        // セッションから一時住所を取得（なければprofileの情報）
        $address = session('temp_address', [
            'postal_code' => $user->profile->postal_code ?? '',
            'address'     => $user->profile->address ?? '',
            'building'    => $user->profile->building ?? '',
        ]);

        // セッションから支払い方法を取得
        $paymentMethod = session('payment_method', null);

        // 編集モード判定
        $editingPayment = $request->boolean('edit_payment');

        return view('purchase.confirm', compact(
            'product',
            'user',
            'address',
            'paymentMethod',
            'editingPayment'
        ));
    }

    // 支払い方法選択時(一時保存)
    public function updatePayment(Request $request, $id)
    {
        session(['payment_method' => $request['payment_method']]);
        return redirect()->route('purchase.confirm', [
            'id'            => $id,
            'edit_payment'  => false, // 編集モード終了
            'edit_address' => request('edit_address') ?? false,
        ]);
    }

    // 配送先住所指定画面
    public function editAddress($id)
    {
        $product = Product::findOrFail($id);
        $user = Auth::user()->load('profile');

        $address = session('temp_address', [
            'postal_code' => $user->profile->postal_code ?? '',
            'address'     => $user->profile->address ?? '',
            'building'    => $user->profile->building ?? '',
        ]);

        return view('purchase.address', compact('product', 'address'));
    }

    // 配送先住所更新
    public function updateAddress(AddressRequest $request, $id)
    {
        $tempAddress = [
            'postal_code' => $request->input('postal_code'),
            'address'     => $request->input('address'),
            'building'    => $request->input('building') ?? '',
        ];

        session(['temp_address' => $tempAddress]);

        return redirect()->route('purchase.confirm', [
        'id'           => $id,
        'edit_payment' => request('edit_payment') ?? false,
    ]);
    }

    public function store(PurchaseRequest $request)
    {
        Order::create([
            'buyer_id'       => $request->buyer_id,
            'product_id'     => $request->product_id,
            'payment_method' => $request->payment_method,
            'postal_code'    => $request->postal_code,
            'address'        => $request->address,
            'building'       => $request->building,
        ]);

        // 商品のis_soldをtrueに更新
        $product = Product::find($request->product_id);
        if ($product) {
            $product->is_sold = true;
            $product->save();
        }

        // 登録後にセッション削除
        session()->forget(['temp_address', 'payment_method']);
        return redirect('/');
    }
}
