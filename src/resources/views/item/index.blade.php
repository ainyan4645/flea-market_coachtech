@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/index.css') }}">
@endsection

@section('content')

<main class="contents">
    <div class="tab-inner">
        @php
            $search = request('search'); // 現在の検索キーワード
        @endphp
        <nav class="tabs">
        <!-- タブ_おすすめ -->
        <a href="{{ route('item.index', ['tab' => 'recommend', 'keyword' => request('keyword')]) }}" class="tab {{ request('tab', 'recommend') === 'recommend' ? 'active' : '' }}">
            おすすめ
        </a>
        <a href="{{ route('item.index', ['tab' => 'mylist', 'keyword' => request('keyword')]) }}" class="tab {{ request('tab') === 'mylist' ? 'active' : '' }}">
            マイリスト
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
                        @if ($product->is_sold)
                            <span class="sold-badge">Sold</span>
                        @endif
                    </div>
                    <p class="content-ttl">{{ $product->name }}</p>
                </a>
            </li>
        @endforeach
    </ul>
</main>
@endsection