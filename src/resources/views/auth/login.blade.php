@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@php($hideHeaderNav = true)

@section('content')
<main class="contents">
    <h1 class="contents_ttl">
        ログイン
    </h1>
    <form class="login" action="/login" method="POST" novalidate>
        @csrf
        <h2 class="login_email">
            メールアドレス
        </h2>
        @error('email')
        <div class="error">{{ $message }}</div>
        @enderror
        <input type="email" name="email" value="{{ old('email') }}" class="login_email_input">
        <h2 class="login_pwd">
            パスワード
        </h2>
        @error('password')
        <div class="error">{{ $message }}</div>
        @enderror
        <input type="password" name="password" class="login_pwd_input">
        <button class="login_btn">ログインする</button>
    </form>
    <a href="{{ route('register') }}" class="register_link">会員登録はこちら</a>
</main>
@endsection