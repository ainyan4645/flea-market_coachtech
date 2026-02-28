@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/detail.css') }}">
@endsection

@section('content')
<main class="content">
    <section class="item">
        <div class="item-inner">
            <img class="item-img" src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
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
            <div class="reaction-like">
                <form action="{{ route('product.favorite', ['item_id' => $product->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="reaction-like-btn">
                        @if ($isFavorite)
                        <img  class="reaction-like-icon" src="{{ asset('img/星アイコン_yellow.png') }}" alt="お気に入り済み">
                        @else
                        <img  class="reaction-like-icon" src="{{ asset('img/星アイコン.png') }}" alt="マイリストに追加">
                        @endif
                    </button>
                </form>
                <span class="reaction-like-cnt">{{ $product->likes()->count() }}</span>
            </div>
            <div class="reaction-comment">
                <div class="reaction-comment-btn">
                    <img class="reaction-comment-icon" src="{{ asset('img/ふきだしアイコン.png') }}" alt="コメント追加">
                </div>
                <span class="reaction-comment-cnt">{{ $comments->count() }}</span>
            </div>
        </div>
        @if ($product->is_sold)
            <span class="purchase-sold">売り切れ</span>
        @else
        <a href="{{ route('purchase.confirm', ['item_id' => $product->id]) }}" class="purchase">購入手続きへ</a>
        @endif
        <div class="detail">
            <h3 class="detail-ttl">
                商品説明
            </h3>
            <p class="detail-txt">
                {{ $product->description }}
            </p>
        </div>
        <div class="type">
            <h3 class="type-ttl">
                商品の情報
            </h3>
            <div class="type-list">
                <h4 class="type-category">
                カテゴリー
                </h4>
                <ul class="type-category-inner">
                    @forelse($product->categories as $category)
                    <li class="type-category-item">
                        {{ $category->name }}
                    </li>
                    @empty
                    <li class="type-category-item">
                        未設定
                    </li>
                    @endforelse
                </ul>
            </div>
            <div class="type-list">
                <h4 class="type-condition">
                    商品の状態
                </h4>
                <p class="type-condition-item">
                    {{ $product->condition_label }}
                </p>
            </div>
        </div>
        <h3 class="comment-ttl">
            コメント({{ $product->comments()->count() }})
        </h3>
        @foreach($product->comments as $comment)
            <div class="comment-header">
                <div class="comment-icon-inner">
                    @if($comment->user && $comment->user->profile && $comment->user->profile->profile_image)
                        <img class="comment-icon" src="{{ asset('storage/' . $comment->user->profile->profile_image) }}" alt="プロフィール画像">
                    @else
                        <div class="comment-icon-placeholder"></div>
                    @endif
                </div>
                <span class="comment-user">
                    {{ $comment->user->name ?? '匿名ユーザー' }}
                </span>
            </div>
            <p class="comment-body">
                {{ $comment->body }}
            </p>
        @endforeach
        <form action="{{ route('item.comment', ['item_id' => $product->id]) }}" method="POST">
            @csrf
            <h4 class="comment-input-ttl">
                商品へのコメント
            </h4>
            @error('body')
                <div class="error">{{ $message }}</div>
            @enderror
            <textarea name="body" class="comment-input-txt">{{ old('body') }}</textarea>
            <button class="comment-input-btn" type="submit">
                コメントを送信する
            </button>
        </form>
    </section>
</main>
@endsection