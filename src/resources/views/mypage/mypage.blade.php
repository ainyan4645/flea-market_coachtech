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
        @foreach($products as $product)
            <li class="content__card">
                <a href="{{ route('item.detail', $product->id) }}" class="content__card__link">
                    <div class="content__img__inner">
                        <img class="content__img" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        @if ($product->is_sold)
                            <span class="sold-badge">Sold</span>
                        @endif
                    </div>
                    <p class="content__ttl">{{ $product->name }}</p>
                </a>
            </li>
        @endforeach
    </ul>
</main>
@endsection