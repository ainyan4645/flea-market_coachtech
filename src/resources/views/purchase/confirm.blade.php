@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/confirm.css') }}">
@endsection

@section('content')
<main class="contents">
    <section class="option">
        <div class="item">
            <div class="item_img_inner">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="item_img">
            </div>
            <div class="item_detail">
                <h1 class="item_detail_name">
                    {{ $product->name }}
                </h1>
                <p class="item_detail_price">
                    ¥ {{ number_format($product->price) }}
                </p>
            </div>
        </div>

        <div class="payment">
            <h2 class="payment_ttl">支払い方法</h2>
            <form action="{{ route('purchase.updatePayment', ['id' => $product->id]) }}" method="POST">
                @csrf
                <select name="payment_method" onchange="this.form.submit()">
                    <option value="">選択してください</option>
                    <option value="convenience" {{ $paymentMethod === 'convenience' ? 'selected' : '' }}>コンビニ支払い</option>
                    <option value="credit" {{ $paymentMethod === 'credit' ? 'selected' : '' }}>カード支払い</option>
                </select>
            </form>
            @error('payment_method')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="address">
            <div class="address_setting">
                <h2 class="address_setting_ttl">
                    配送先
                </h2>
                <a href="{{ route('purchase.address', ['id' => $product->id]) }}" class="address_setting_btn">
                    変更する
                </a>
            </div>
            <p class="address_postcode">〒 {{ $address['postal_code'] ?: '未設定' }}</p>
            <p class="address_detail">
                {{ $address['address'] ?: '住所未登録' }}
                {{ $address['building'] ?? '' }}
            </p>
            @error('postal_code')
                <p class="error">{{ $message }}</p>
            @enderror
            @error('address')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
    </section>

    <section class="confirm">
        <div class="confirm_inner">
            <div class="confirm_price">
                <h3 class="confirm_ttl">
                    商品代金
                </h3>
                <input class="confirm_option" value="¥ {{ number_format($product->price) }}" readonly>
            </div>
            <div class="confirm_payment">
                <h3 class="confirm_ttl">
                    支払い方法
                </h3>
                <input class="confirm_option" value="{{ $paymentMethod === 'convenience' ? 'コンビニ支払い' : ($paymentMethod === 'credit' ? 'カード支払い' : '未選択') }}" readonly>
            </div>
        </div>
        <form action="{{ route('purchase.store') }}" method="POST">
            @csrf
            {{-- hidden --}}
            <input type="hidden" name="buyer_id" value="{{ $user->id }}">
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="payment_method" value="{{ $paymentMethod }}">
            <input type="hidden" name="postal_code" value="{{ $address['postal_code'] }}">
            <input type="hidden" name="address" value="{{ $address['address'] }}">
            <input type="hidden" name="building" value="{{ $address['building'] }}">

            <button type="submit" class="confirm_purchase">購入する</button>
        </form>
    </section>
</main>
@endsection