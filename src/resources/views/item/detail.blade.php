@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/detail.css') }}">
@endsection

@section('content')
<main class="content">
    <section class="content_img">
        <div class="content_img_inner">
            <img src="" alt="商品画像" class="img">
        </div>
    </section>
    <section class="content_info">
        <h1 class="content_ttl">
            商品名がここに入る
        </h1>
        <h2 class="content_brand">
            ブランド名
        </h2>
        <p class="content_price">
            ¥47,000(税込)
        </p>
        <div class="content_reaction">
            <div class="content_reaction_like">
                ⭐️
            </div>
            <div class="content_reaction_comment">
                📝
            </div>
        </div>
        <button class="content_purchase">
            購入手続きへ
        </button>
        <div class="content_detail">
            <h3 class="content_detail_ttl">
                商品説明
            </h3>
        </div>
        <div class="content_type">
            <h3 class="content_type_ttl">
                商品の情報
            </h3>
        </div>
        <div class="content_comment">
            <h3 class="content_comment_ttl">
                コメント(1)
            </h3>
        </div>
    </section>
</main>
@endsection