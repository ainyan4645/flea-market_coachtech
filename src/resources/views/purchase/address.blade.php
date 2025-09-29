@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/address.css') }}">
@endsection

@section('content')
<main class="contents">
    <h1 class="contents_ttl">
        住所の変更
    </h1>
    <form class="contents_update" action="">
        <div class="postcode">
            <h2 class="postcode_ttl">
                郵便番号
            </h2>
            <input type="text" class="postcode_txt">
        </div>
        <div class="address">
            <h2 class="address_ttl">
                住所
            </h2>
            <input type="text" class="address_txt">
        </div>
        <div class="building">
            <h2 class="building_ttl">
                建物名
            </h2>
            <input type="text" class="building_txt">
        </div>
        <button class="contents_update_btn">
            更新する
        </button>
    </form>
</main>
@endsection