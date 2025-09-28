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
                <button class="content_reaction_like-btn">
                    <img  class="content_reaction_like-icon" src="{{ asset('img/星アイコン.png') }}" alt="マイリストに追加">
                </button>
                <span class="content_reaction_like-cnt">1</span>
            </div>
            <div class="content_reaction_comment">
                <a class="content_reaction_comment-btn" href="#comments">
                    <img class="content_reaction_comment-icon" src="{{ asset('img/ふきだしアイコン.png') }}" alt="コメント追加">
                </a>
                <span class="content_reaction_comment-cnt">2</span>
            </div>
        </div>
        <button class="content_purchase">
            購入手続きへ
        </button>
        <div class="content_detail">
            <h3 class="content_detail_ttl">
                商品説明
            </h3>
            <p class="content_detail_txt">
                カラー：グレー<br>
                新品
                商品の状態は良好です。傷もありません。<br>
                購入後、即発送いたします。
            </p>
        </div>
        <div class="content_type">
            <h3 class="content_type_ttl">
                商品の情報
            </h3>
            <div class="content_type-list">
                <h4 class="content_type-category">
                カテゴリー
                </h4>
                <ul class="content_type-category_inner">
                    <li class="content_type-category_item">洋服</li>
                    <li class="content_type-category_item">メンズ</li>
                    <li class="content_type-category_item">メンズ</li>
                    <li class="content_type-category_item">メンズ</li>
                    <li class="content_type-category_item">メンズ</li>
                </ul>
            </div>
            <div class="content_type-list">
                <h4 class="content_type-condition">
                    商品の状態
                </h4>
                <p class="content_type-condition_item">良好</p>
            </div>
        <div class="content_comment" id="comments">
            <h3 class="content_comment_ttl">
                コメント(1)
            </h3>
        </div>
    </section>
</main>
@endsection