@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/index.css') }}">
@endsection

@section('content')

<main class="contents">
    <div class="tab__inner">
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
    <ul class="content__list">
        @foreach($products as $product)
            <li class="content__card">
                <a href="{{ route('item.detail', $product->id) }}" class="content__card__link">
                    <div class="content__img__inner">
                        @if ($product->image_url)
                            <img class="content__img" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        @else
                            <div class="no-image">NO IMAGE</div>
                        @endif
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