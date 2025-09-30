@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/detail.css') }}">
@endsection

@section('content')
<main class="content">
    <section class="item">
        <div class="item_inner">
            <img src="" alt="商品画像" class="item_img">
        </div>
    </section>
    <section class="info">
        <h1 class="ttl">
            商品名がここに入る
        </h1>
        <h2 class="brand">
            ブランド名
        </h2>
        <p class="price">
            ¥47,000(税込)
        </p>
        <div class="reaction">
            <div class="reaction_like">
                <button class="reaction_like_btn">
                    <img  class="reaction_like_icon" src="{{ asset('img/星アイコン.png') }}" alt="マイリストに追加">
                </button>
                <span class="reaction_like_cnt">1</span>
            </div>
            <div class="reaction_comment">
                <div class="reaction_comment_btn">
                    <img class="reaction_comment_icon" src="{{ asset('img/ふきだしアイコン.png') }}" alt="コメント追加">
                </div>
                <span class="reaction_comment_cnt">2</span>
            </div>
        </div>
        <button class="purchase">
            購入手続きへ
        </button>
        <div class="detail">
            <h3 class="detail_ttl">
                商品説明
            </h3>
            <p class="detail_txt">
                カラー：グレー<br>
                新品
                商品の状態は良好です。傷もありません。<br>
                購入後、即発送いたします。
            </p>
        </div>
        <div class="type">
            <h3 class="type_ttl">
                商品の情報
            </h3>
            <div class="type_list">
                <h4 class="type_category">
                カテゴリー
                </h4>
                <ul class="type_category_inner">
                    <li class="type_category_item">洋服</li>
                    <li class="type_category_item">メンズ</li>
                    <li class="type_category_item">メンズ</li>
                    <li class="type_category_item">メンズ</li>
                    <li class="type_category_item">メンズ</li>
                </ul>
            </div>
            <div class="type_list">
                <h4 class="type_condition">
                    商品の状態
                </h4>
                <p class="type_condition_item">良好</p>
            </div>
        </div>
        <h3 class="comment_ttl">
            コメント(1)
        </h3>
        <div class="comment_item">
            <div class="comment_header">
                <div class="comment_icon_inner">
                    <img class="comment_icon" src="" alt="ユーザアイコン">
                </div>
                <span class="comment_user">
                    admin
                </span>
            </div>
            <p class="comment_body">
                こちらにコメントが入ります。
            </p>
        </div>
        <form action="">
            <h4 class="comment_input_ttl">
                商品へのコメント
            </h4>
            <input type="text" class="comment_input_txt">
            <button class="comment_input_btn">
                コメントを送信する
            </button>
        </form>
    </section>
</main>
@endsection