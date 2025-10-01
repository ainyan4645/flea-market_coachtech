@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/sell.css') }}">
@endsection

@section('content')
<main class="contents">
    <h1 class="contents_ttl">
        商品の出品
    </h1>
    <form action="">
        <h3 class="img_ttl">
            商品画像
        </h3>
        <div class="img_upload_area">
            <label class="img_upload_label">
                画像を選択する
                <input type="file" name="image" class="img_upload_input" accept="">
            </label>
        </div>
        <h2 class="type_ttl">
            商品の詳細
        </h2>
        <h3 class="type_category_ttl">
            カテゴリー
        </h3>
        <ul class="type_category_inner">
            <!-- あとでforeachで議一つにする -->
            <li>
                <label class="type_category_item">
                    <input type="checkbox" class="type_category_check">
                    ファッション
                </label>
            </li>
            <li class="type_category_item">家電</li>
            <li class="type_category_item">インテリア</li>
            <li class="type_category_item">レディース</li>
            <li class="type_category_item">メンズ</li>
            <li class="type_category_item">コスメ</li>
            <li class="type_category_item">本</li>
            <li class="type_category_item">ゲーム</li>
            <li class="type_category_item">スポーツ</li>
            <li class="type_category_item">キッチン</li>
            <li class="type_category_item">ハンドメイド</li>
            <li class="type_category_item">アクセサリー</li>
            <li class="type_category_item">おもちゃ</li>
            <li class="type_category_item">ベビー・キッズ</li>
        </ul>
        <h3 class="type_condition_ttl">
            商品の状態
        </h3>
        <select class="type_condition_select" name="" id="">
            選択してください
        </select>
        <h2 class="detail_ttl">
            商品名と説明
        </h2>
        <h3 class="detail_name_ttl">
            商品名
        </h3>
        <input type="text" class="detail_name_input">
        <h3 class="detail_brand_ttl">
            ブランド名
        </h3>
        <input type="text" class="detail_brand_input">
        <h3 class="detail_description_ttl">
            商品の説明
        </h3>
        <input type="text" class="detail_description_input">
        <h3 class="detail_price_ttl">
            販売価格
        </h3>
        <input type="text" class="detail_price_input">¥
        <button class="sell_btn">
            出品する
        </button>
    </form>
</main>
@endsection