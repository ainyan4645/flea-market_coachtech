@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@php($hideHeaderNav = true)

@section('content')
<main class="contents">
    <h1 class="contents_ttl">
        会員登録
    </h1>
    <form class="register" action="/register" method="POST" novalidate>
        @csrf
        <h2 class="register_user">
            ユーザー名
        </h2>
        @error('name')
        <div class="error">{{ $message }}</div>
        @enderror
        <input type="text" name="name" value="{{ old('name') }}" class="register_user_input">

        <h2 class="register_email">
            メールアドレス
        </h2>
        @error('email')
        <div class="error">{{ $message }}</div>
        @enderror
        <input type="email" name="email" value="{{ old('email') }}" class="register_email_input">

        <h2 class="register_pwd">
            パスワード
        </h2>
        @error('password')
        <div class="error">{{ $message }}</div>
        @enderror
        <input type="password" name="password" class="register_pwd_input">

        <h2 class="register_pwd-confirm">
            確認用パスワード
        </h2>
        <input type="password" name="password_confirmation" class="register_pwd-confirm_input">

        <button class="register_btn" type="submit">登録する</button>
    </form>
    <a href="{{ route('login') }}" class="login_link">ログインはこちら</a>
</main>
@endsection