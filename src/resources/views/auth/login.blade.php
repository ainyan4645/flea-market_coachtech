@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<main class="contents">
    <h1 class="contents_ttl">
        ログイン
    </h1>
    <form class="login" action="">
        <h2 class="login_email">
            メールアドレス
        </h2>
        <input type="text" class="login_email_input">
        <h2 class="login_pwd">
            パスワード
        </h2>
        <input type="text" class="login_pwd_input">
        <button class="login_btn">ログインする</button>
    </form>
    <a href="" class="register_link">会員登録はこちら</a>
</main>
@endsection