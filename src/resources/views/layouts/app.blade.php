<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECHフリマ</title>
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/common.css') }}">
    @yield('css')
</head>
<body>
    <header class="header__inner">
        <a href="/" class="header-logo__inner">
            <img src="{{ asset('img/logo.svg') }}" alt="header-logo" class="header-logo_img">
        </a>
        @if (!isset($hideHeaderNav) || !$hideHeaderNav)
        <form class="search-box" action="{{ route('item.index') }}" method="GET">
            <input class="search-box__keyword" type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
            @if (request('tab'))
                <input type="hidden" name="tab" value="{{ request('tab') }}">
            @endif
        </form>
        <nav class="header-nav">
            <ul class="header-nav__inner">
            {{-- ログイン中 --}}
                @auth
                <li class="header-nav__ttl__black">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="header-nav__ttl__txt">ログアウト</button>
                    </form>
                </li>
                <li class="header-nav__ttl__black">
                    <a class="header-nav__ttl__txt" href="{{ route('mypage') }}">マイページ</a>
                </li>
                <li class="header-nav__ttl__white">
                    <a class="header-nav__ttl__txt" href="{{ route('sell') }}">出品</a>
                </li>
                @endauth

                {{-- 非ログイン中 --}}
                @guest
                <li class="header-nav__ttl__black">
                    <a class="header-nav__ttl__txt" href="{{ route('login') }}">ログイン</a>
                </li>
                <li class="header-nav__ttl__black">
                    <a class="header-nav__ttl__txt" href="{{ route('login') }}">マイページ</a>
                </li>
                <li class="header-nav__ttl__white">
                    <a class="header-nav__ttl__txt" href="{{ route('login') }}">出品</a>
                </li>
                @endguest
            </ul>
        </nav>
        @endif
    </header>
    @yield('content')
</body>
</html>