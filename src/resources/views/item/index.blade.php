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
        @auth
        <a href="{{ url('/?tab=mylist') }}" class="tab {{ request('tab') === 'mylist' ? 'active' : '' }}">
            マイリスト
        </a>
        @endauth
        @guest
        <a href="{{ route('login') }}" class="tab {{ request('tab') === 'mylist' ? 'active' : '' }}">
            マイリスト
        </a>
        @endguest
        </nav>
    </div>

    <!-- 商品リスト部分 -->
    <ul class="content__list">
        @foreach($products as $product)
            <li class="content__card">
                <div class="content__img__inner">
                    @if ($product->image_url)
                        <img class="content__img" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    @else
                        <div class="no-image">NO IMAGE</div>
                    @endif
                </div>
                <p class="content__ttl">{{ $product->name }}</p>
            </li>
        @endforeach
    </ul>
</main>
@endsection