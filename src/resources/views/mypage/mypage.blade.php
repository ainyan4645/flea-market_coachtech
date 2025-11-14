@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/mypage.css') }}">
@endsection

@section('content')
<main>
    <div class="user">
    <div class="user-icon-inner">
            <img src="{{ asset('storage/' . $user->profile->profile_image) }}" alt="プロフィール画像" class="user-icon">
        </div>
        <p class="user-name">
            {{ $user->name }}
        </p>
        <a href="{{ route('mypage.edit') }}" class="user-edit-btn">
            プロフィールを編集
        </a>
    </div>
    <div class="tab-inner">
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
    <ul class="content-list">
        @foreach($products as $product)
            <li class="content-card">
                <a href="{{ route('item.detail', $product->id) }}" class="content-card-link">
                    <div class="content-img-inner">
                        <img class="content-img" src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
                    </div>
                    <p class="content-ttl">{{ $product->name }}</p>
                </a>
            </li>
        @endforeach
    </ul>
</main>
@endsection