@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/mypage_edit.css') }}">
@endsection

@section('content')
<main class="contents">
    <h1 class="contents_ttl">
        プロフィール設定
    </h1>
    <form action="">
        <div class="img">
            <div class="img_inner">
                <img src="" alt="" class="img_display">
            </div>
            <span class="img_upload_btn">
                画像を選択する
                <input type="file" class="img_upload_input">
            </span>
        </div>
        <h2 class="name">
            ユーザー名
        </h2>
        <input type="text" class="name_input" placeholder="既存の値が入力されている">
        <h2 class="post">
            郵便番号
        </h2>
        <input type="text" class="post_input">
        <h2 class="address">
            住所
        </h2>
        <input type="text" class="address_input">
        <h2 class="building">
            建物名
        </h2>
        <input type="text" class="building_input">
        <button class="edit_btn">
            更新する
        </button>
    </form>
</main>
@endsection