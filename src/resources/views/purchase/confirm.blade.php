@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/confirm.css') }}">
@endsection

@section('content')
<main class="contents">
    <section class="option">
        <div class="item">
            <div class="item-img-inner">
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="item-img">
            </div>
            <div class="item-detail">
                <h1 class="item-detail-name">
                    {{ $product->name }}
                </h1>
                <p class="item-detail-price">
                    ¥ {{ number_format($product->price) }}
                </p>
            </div>
        </div>

        <div class="payment">
            <h2 class="payment-ttl">支払い方法</h2>
            @error('payment_method')
                <p class="error">{{ $message }}</p>
            @enderror
            <form action="{{ route('purchase.updatePayment', ['item_id' => $product->id]) }}" method="POST">
                @csrf
                <select name="payment_method" class="payment-method" onchange="this.form.submit()">
                    <option value="">選択してください</option>
                    <option value="convenience" {{ $paymentMethod === 'convenience' ? 'selected' : '' }}>コンビニ支払い</option>
                    <option value="credit" {{ $paymentMethod === 'credit' ? 'selected' : '' }}>カード支払い</option>
                </select>
            </form>
        </div>

        <div class="address">
            <div class="address-setting">
                <h2 class="address-setting-ttl">
                    配送先
                </h2>
                <a href="{{ route('purchase.address', ['item_id' => $product->id]) }}" class="address-setting-btn">
                    変更する
                </a>
            </div>
            @error('postal_code')
                <p class="error">{{ $message }}</p>
            @enderror
            @error('address')
                <p class="error">{{ $message }}</p>
            @enderror
            <p class="address-postcode">〒 {{ $address['postal_code'] ?: '未設定' }}</p>
            <p class="address-detail">
                {{ $address['address'] ?: '住所未登録' }}
                {{ $address['building'] ?? '' }}
            </p>
        </div>
    </section>

    <section class="confirm">
        <div class="confirm-inner">
            <div class="confirm-price">
                <h3 class="confirm-ttl">
                    商品代金
                </h3>
                <input class="confirm-option" value="¥ {{ number_format($product->price) }}" readonly>
            </div>
            <div class="confirm-payment">
                <h3 class="confirm-ttl">
                    支払い方法
                </h3>
                <input class="confirm-option" value="{{ $paymentMethod === 'convenience' ? 'コンビニ支払い' : ($paymentMethod === 'credit' ? 'カード支払い' : '未選択') }}" readonly>
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

            <button type="submit" class="confirm-purchase">購入する</button>
        </form>
    </section>
</main>
@endsection