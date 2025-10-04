@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/mypage.css') }}">
@endsection

@section('content')
<main>
    <div class="user">
    <div class="user_icon_inner">
            <img src="" alt="" class="user_icon">
        </div>
        <p class="user_name">
            ユーザー名
        </p>
        <a href="" class="user_edit_btn">
            プロフィールを編集
        </a>
    </div>
    <div class="tab__inner">
        <nav class="tabs">
        <!-- タブ_おすすめ -->
        <a href="{{ url('/mypage?page=sell') }}" class="tab {{ request('page', 'sell') === 'sell' ? 'active' : '' }}">
            出品した商品
        </a>
        <a href="{{ url('/mypage?page=buy') }}" class="tab {{ request('page') === 'buy' ? 'active' : '' }}">
            購入した商品
        </a>
        </nav>
    </div>
    <!-- 商品リスト部分 -->
    <ul class="content__list">
            <li class="content__card">
                <div class="content__img__inner">
                    <img class="content__img" src="" alt="商品1">
                </div>
                <p class="content__ttl">商品_おすすめ</p>
            </li>
            <li class="content__card">
                <div class="content__img__inner">
                    <img class="content__img" src="" alt="商品2">
                </div>
                <p class="content__ttl">商品_マイリスト</p>
            </li>
            <li class="content__card">
                <div class="content__img__inner">
                    <img src="" alt="商品2">
                </div>
                <p class="content__ttl">商品_マイリスト</p>
            </li>
            <li class="content__card">
                <div class="content__img__inner">
                    <img class="content__img" src="" alt="商品2">
                </div>
                <p class="content__ttl">商品_マイリスト</p>
            </li>
            <li class="content__card">
                <div class="content__img__inner">
                    <img class="content__img" src="" alt="商品2">
                </div>
                <p class="content__ttl">商品_マイリスト</p>
            </li>
            <li class="content__card">
                <div class="content__img__inner">
                    <img class="content__img" src="" alt="商品2">
                </div>
                <p class="content__ttl">商品_マイリスト</p>
            </li>
            <li class="content__card">
                <div class="content__img__inner">
                    <img class="content__img" src="" alt="商品1">
                </div>
                <p class="content__ttl">商品_おすすめ</p>
            </li>
            <li class="content__card">
                <div class="content__img__inner">
                    <img class="content__img" src="" alt="商品1">
                </div>
                <p class="content__ttl">商品_おすすめ</p>
            </li>
            <li class="content__card">
                <div class="content__img__inner">
                    <img class="content__img" src="" alt="商品1">
                </div>
                <p class="content__ttl">商品_おすすめ</p>
            </li>
    </ul>
</main>
@endsection