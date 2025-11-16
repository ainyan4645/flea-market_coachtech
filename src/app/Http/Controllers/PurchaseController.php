<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    public function confirm($item_id, Request $request)
    {
        $product = Product::findOrFail($item_id);
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
    public function updatePayment(Request $request, $item_id)
    {
        session(['payment_method' => $request['payment_method']]);
        return redirect()->route('purchase.confirm', [
            'item_id'            => $item_id,
            'edit_payment'  => false, // 編集モード終了
            'edit_address' => request('edit_address') ?? false,
        ]);
    }

    // 配送先住所指定画面
    public function editAddress($item_id)
    {
        $product = Product::findOrFail($item_id);
        $user = Auth::user()->load('profile');

        $address = session('temp_address', [
            'postal_code' => $user->profile->postal_code ?? '',
            'address'     => $user->profile->address ?? '',
            'building'    => $user->profile->building ?? '',
        ]);

        return view('purchase.address', compact('product', 'address'));
    }

    // 配送先住所更新
    public function updateAddress(AddressRequest $request, $item_id)
    {
        $tempAddress = [
            'postal_code' => $request->input('postal_code'),
            'address'     => $request->input('address'),
            'building'    => $request->input('building') ?? '',
        ];

        session(['temp_address' => $tempAddress]);

        return redirect()->route('purchase.confirm', [
        'item_id'           => $item_id,
        'edit_payment' => request('edit_payment') ?? false,
    ]);
    }

    // 決済画面へ
    public function checkout(PurchaseRequest $request, $item_id)
    {
        $validated = $request->validated();
        $product = Product::findOrFail($item_id);

        // 先に注文登録
        Order::create([
            'buyer_id'       => auth()->id(),
            'product_id'     => $item_id,
            'payment_method' => $validated['payment_method'],
            'postal_code'    => $validated['postal_code'],
            'address'        => $validated['address'],
            'building'       => $validated['building'] ?? null,
        ]);

        $product->update(['is_sold' => true]);

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        // 購入画面で選択した支払い方法に応じて決済手段を指定
        $paymentTypes = match($validated['payment_method']) {
            'credit'      => ['card'],
            'convenience' => ['konbini'],
            default       => ['card'],    // 安全対策
        };

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => $paymentTypes,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => ['name' => $product->name],
                    'unit_amount' => $product->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/'), // 今回は success は未対応
            'cancel_url'  => url('/'), // 今回は cancel は未対応
        ]);

        return redirect($session->url);
    }
}
