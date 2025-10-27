@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/sell.css') }}">
@endsection

@section('content')
<main class="contents">
    <h1 class="contents_ttl">
        商品の出品
    </h1>
    <form action="{{ route('sell.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h3 class="img_ttl">
            商品画像
        </h3>
        @error('image_path')
            <div class="error">{{ $message }}</div>
        @enderror
        <div class="img_upload_area">
            <label class="img_upload_label">
                画像を選択する
                <input type="file" name="image_path" class="img_upload_input" accept="image/*">
            </label>
        </div>
        <h2 class="type_ttl">
            商品の詳細
        </h2>
        <h3 class="type_category_ttl">
            カテゴリー
        </h3>
        @error('categories')
        <div class="error">{{ $message }}</div>
        @enderror
        <ul class="type_category_inner">
            @foreach($categories as $category)
            <li>
                <label class="type_category_item">
                    <input type="checkbox" name="categories[]" class="type_category_check" value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                    {{ $category->name }}
                </label>
            </li>
            @endforeach
        </ul>
        <h3 class="type_condition_ttl">
            商品の状態
        </h3>
        @error('condition')
        <div class="error">{{ $message }}</div>
        @enderror
        <select name="condition" class="type_condition_select">
            <option value="">選択してください</option>
            <option class="type_condition_select-option" value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>良好</option>
            <option class="type_condition_select-option" value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>目立った傷や汚れなし</option>
            <option class="type_condition_select-option" value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>やや傷や汚れあり</option>
            <option class="type_condition_select-option" value="bad" {{ old('condition') == 'bad' ? 'selected' : '' }}>状態が悪い</option>
        </select>
        <h2 class="detail_ttl">
            商品名と説明
        </h2>
        <h3 class="detail_name_ttl">
            商品名
        </h3>
        @error('name')
        <div class="error">{{ $message }}</div>
        @enderror
        <input type="text" name="name" value="{{ old('name') }}" class="detail_name_input">
        <h3 class="detail_brand_ttl">
            ブランド名
        </h3>
        @error('brand')
        <div class="error">{{ $message }}</div>
        @enderror
        <input type="text" name="brand" value="{{ old('brand') }}" class="detail_brand_input">
        <h3 class="detail_description_ttl">
            商品の説明
        </h3>
        @error('description')
        <div class="error">{{ $message }}</div>
        @enderror
        <textarea name="description" class="detail_description_input">{{ old('description') }}</textarea>
        <h3 class="detail_price_ttl">
            販売価格
        </h3>
        @error('price')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="detail_price_wrapper">
            <span class="detail_price_prefix">¥</span>
            <input type="text" name="price" value="{{ old('price') }}" class="detail_price_input">
        </div>
        <button class="sell_btn">
            出品する
        </button>
    </form>
</main>
@endsection