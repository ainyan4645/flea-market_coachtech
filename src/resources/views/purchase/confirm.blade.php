@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/confirm.css') }}">
@endsection

@section('content')
<main class="contents">
    <section class="option">
        <div class="item">
            <div class="item_img_inner">
                <img src="" alt="商品画像" class="item_img">
            </div>
            <div class="item_detail">
                <h1 class="item_detail_name">
                    商品名
                </h1>
                <p class="item_detail_price">
                    ¥ 47,000
                </p>
            </div>
        </div>
        <div class="payment">
            <h2 class="payment_ttl">
                支払い方法
            </h2>
            <select name="" id="" class="payment_method" value="選択してください"></select>
        </div>
        <div class="address">
            <h2 class="address_ttl">
                配送先
            </h2>
            <button type="button"  class="address_setting-btn">
                設定する
            </button>
            <p class="address_postcode">〒 xxx-yyyy</p>
            <p class="address_detail">
                ここには住所と建物が入ります
            </p>
        </div>
    </section>
    <section class="confirm">
        <div class="confirm_price_inner">
            <h3 class="confirm_price_ttl">
                商品代金
            </h3>
            <p class="confirm_price">¥ 47,000</p>
        </div>
        <div class="confirm_payment_inner">
            <h3 class="confirm_payment_ttl">
                支払い方法
            </h3>
            <p class="confirm_payment">
                コンビニ払い
            </p>
        </div>
        <button class="confirm_purchase"></button>
    </section>
</main>
@endsection