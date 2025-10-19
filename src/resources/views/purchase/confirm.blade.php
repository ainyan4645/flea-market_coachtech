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
            <h2 class="payment_ttl">
                支払い方法
            </h2>
            <select name="payment_method" class="payment_method">
                <option value="">選択してください</option>
                <option value="convenience">コンビニ払い</option>
                <option value="credit">カード払い</option>
            </select>
        </div>
        <div class="address">
            <div class="address_setting">
                <h2 class="address_setting_ttl">
                    配送先
                </h2>
                <button type="button"  class="address_setting_btn">
                    変更する
                </button>
            </div>
            <p class="address_postcode">〒 xxx-yyyy</p>
            <p class="address_detail">
                ここには住所と建物が入ります
            </p>
        </div>
    </section>
    <form class="confirm" action="" method="POST">
        @csrf
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
                <input class="confirm_option" value="コンビニ払い" readonly>
            </div>
        </div>
        <button class="confirm_purchase">購入する</button>
    </form>
</main>
@endsection