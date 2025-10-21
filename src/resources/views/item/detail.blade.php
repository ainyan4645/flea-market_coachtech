@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/detail.css') }}">
@endsection

@section('content')
<main class="content">
    <section class="item">
        <div class="item__inner">
            @if ($product->image_url)
                <img class="item__img" src="{{ $product->image_url }}" alt="{{ $product->name }}">
            @else
                <div class="no-image">NO IMAGE</div>
            @endif
            @if ($product->is_sold)
                <span class="sold-badge">Sold</span>
            @endif
        </div>
    </section>
    <section class="info">
        <h1 class="ttl">
            {{ $product->name }}
        </h1>
        <h2 class="brand">
            {{ $product->brand ?? '' }}
        </h2>
        <p class="price">
            ¥{{ number_format($product->price) }} (税込)
        </p>
        <div class="reaction">
            <div class="reaction_like">
                <form action="{{ route('product.favorite', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="reaction_like_btn">
                        @if ($isFavorite)
                        <img  class="reaction_like_icon" src="{{ asset('img/星アイコン_yellow.png') }}" alt="お気に入り済み">
                        @else
                        <img  class="reaction_like_icon" src="{{ asset('img/星アイコン.png') }}" alt="マイリストに追加">
                        @endif
                    </button>
                </form>
                <span class="reaction_like_cnt">{{ $product->likes()->count() }}</span>
            </div>
            <div class="reaction_comment">
                <div class="reaction_comment_btn">
                    <img class="reaction_comment_icon" src="{{ asset('img/ふきだしアイコン.png') }}" alt="コメント追加">
                </div>
                <span class="reaction_comment_cnt">{{ $comments->count() }}</span>
            </div>
        </div>
        @if ($product->is_sold)
            <span class="purchase sold">売り切れ</span>
        @else
        <a href="{{ route('purchase.confirm', $product->id) }}" class="purchase">購入手続きへ</a>
        @endif
        <div class="detail">
            <h3 class="detail_ttl">
                商品説明
            </h3>
            <p class="detail_txt">
                {{ $product->description }}
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
                    @forelse($product->categories as $category)
                    <li class="type_category_item">
                        {{ $category->name }}
                    </li>
                    @empty
                    <li class="type_category_item">
                        未設定
                    </li>
                    @endforelse
                </ul>
            </div>
            <div class="type_list">
                <h4 class="type_condition">
                    商品の状態
                </h4>
                <p class="type_condition_item">
                    {{ $product->condition_label }}
                </p>
            </div>
        </div>
        <h3 class="comment_ttl">
            コメント({{ $product->comments()->count() }})
        </h3>
        @foreach($product->comments as $comment)
            <div class="comment_header">
                <div class="comment_icon_inner">
                    <img class="comment_icon" src="{{ $comment->user->icon ?? '' }}" alt="{{ $comment->user->name }}">
                </div>
                <span class="comment_user">
                    {{ $comment->user->name ?? '匿名ユーザー' }}
                </span>
            </div>
            <p class="comment_body">
                {{ $comment->body }}
            </p>
        @endforeach
        <form action="{{ route('item.comment', $product->id) }}" method="POST">
            @csrf
            <h4 class="comment_input_ttl">
                商品へのコメント
            </h4>
            @error('body')
                <div class="error">{{ $message }}</div>
            @enderror
            <textarea name="body" class="comment_input_txt">{{ old('body') }}</textarea>
            <button class="comment_input_btn" type="submit">
                コメントを送信する
            </button>
        </form>
    </section>
</main>
@endsection