@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/sell.css') }}">
@endsection

@section('content')
<main class="contents">
    <h1 class="contents-ttl">
        商品の出品
    </h1>
    <form action="{{ route('sell.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h3 class="img-ttl">
            商品画像
        </h3>
        @error('image_path')
            <div class="error">{{ $message }}</div>
        @enderror
        <div class="img-upload-area">
            <label class="img-upload-label">
                画像を選択する
                <input type="file" name="image_path" class="img-upload-input" accept="image/*">
            </label>
        </div>
        <h2 class="type-ttl">
            商品の詳細
        </h2>
        <h3 class="type-category-ttl">
            カテゴリー
        </h3>
        @error('categories')
        <div class="error">{{ $message }}</div>
        @enderror
        <ul class="type-category-inner">
            @foreach($categories as $category)
            <li>
                <label class="type-category-item">
                    <input type="checkbox" name="categories[]" class="type-category-check" value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                    {{ $category->name }}
                </label>
            </li>
            @endforeach
        </ul>
        <h3 class="type-condition-ttl">
            商品の状態
        </h3>
        @error('condition')
        <div class="error">{{ $message }}</div>
        @enderror
        <select name="condition" class="type-condition-select">
            <option value="">選択してください</option>
            <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>良好</option>
            <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>目立った傷や汚れなし</option>
            <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>やや傷や汚れあり</option>
            <option value="bad" {{ old('condition') == 'bad' ? 'selected' : '' }}>状態が悪い</option>
        </select>
        <h2 class="detail-ttl">
            商品名と説明
        </h2>
        <h3 class="detail-name-ttl">
            商品名
        </h3>
        @error('name')
        <div class="error">{{ $message }}</div>
        @enderror
        <input type="text" name="name" value="{{ old('name') }}" class="detail-name-input">
        <h3 class="detail-brand-ttl">
            ブランド名
        </h3>
        @error('brand')
        <div class="error">{{ $message }}</div>
        @enderror
        <input type="text" name="brand" value="{{ old('brand') }}" class="detail-brand-input">
        <h3 class="detail-description-ttl">
            商品の説明
        </h3>
        @error('description')
        <div class="error">{{ $message }}</div>
        @enderror
        <textarea name="description" class="detail-description-input">{{ old('description') }}</textarea>
        <h3 class="detail-price-ttl">
            販売価格
        </h3>
        @error('price')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="detail-price-wrapper">
            <span class="detail-price-prefix">¥</span>
            <input type="text" name="price" value="{{ old('price') }}" class="detail-price-input">
        </div>
        <button class="sell-btn">
            出品する
        </button>
    </form>
</main>
@endsection