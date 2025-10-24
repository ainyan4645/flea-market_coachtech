@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/mypage_edit.css') }}">
@endsection

@section('content')
<main class="contents">
    <h1 class="contents_ttl">
        プロフィール設定
    </h1>

    <form action="{{ route('mypage.upload.temp') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="img">
            <div class="img_inner">
                @if(session('temp_image'))
                    <img src="{{ asset('storage/' . session('temp_image')) }}" alt="一時画像" class="img_display">
                @elseif($profile && $profile->profile_image)
                    <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="プロフィール画像" class="img_display">
                @else
                    <img src="" alt="" class="img_display">
                @endif
            </div>

            <div class="img_upload_inner">
                <label class="img_upload_btn">
                    画像を選択する
                    <input type="file" class="img_upload_input" name="profile_image" accept="image/*" onchange="this.form.submit()">
                </label>
                <span class="file_name">
                    @if (session('temp_image'))
                        {{ basename(session('temp_image')) }}
                    @endif
                </span>
            </div>
        </div>
    </form>

    <form action="{{ route('mypage.update') }}" method="POST">
        @csrf
        <h2 class="name">ユーザー名</h2>
        @error('name')
        <div class="error">{{ $message }}</div>
        @enderror
        <input type="text" name="name" class="name_input" value="{{ old('name', $profile->name ?? auth()->user()->name ?? '') }}">

        <h2 class="post">郵便番号</h2>
        @error('postal_code')
        <div class="error">{{ $message }}</div>
        @enderror
        <input type="text" name="postal_code" class="post_input" value="{{ old('postal_code', $profile->postal_code ?? '') }}">

        <h2 class="address">住所</h2>
        @error('address')
        <div class="error">{{ $message }}</div>
        @enderror
        <input type="text" name="address" class="address_input" value="{{ old('address', $profile->address ?? '') }}">

        <h2 class="building">建物名</h2>
        @error('building')
        <div class="error">{{ $message }}</div>
        @enderror
        <input type="text" name="building" class="building_input" value="{{ old('building', $profile->building ?? '') }}">

        <button class="edit_btn">更新する</button>
    </form>
</main>
@endsection