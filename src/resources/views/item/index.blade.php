@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/index.css') }}">
@endsection

@section('content')

<main class="contents">
    <div class="tab__inner">
        <nav class="tabs">
        <!-- タブ_おすすめ -->
        <a href="{{ url('/') }}" class="tab {{ request('tab', 'recommend') === 'recommend' ? 'active' : '' }}">
            おすすめ
        </a>
        <a href="{{ url('/?tab=mylist') }}" class="tab {{ request('tab') === 'mylist' ? 'active' : '' }}">
            マイリスト
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