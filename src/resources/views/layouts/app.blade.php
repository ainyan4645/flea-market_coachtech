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
    <header class="header-inner">
        <a href="/" class="header-logo-inner">
            <img src="{{ asset('img/logo.svg') }}" alt="header-logo" class="header-logo_img">
        </a>
        @if (!isset($hideHeaderNav) || !$hideHeaderNav)
        <form class="search-box" action="{{ route('item.index') }}" method="GET">
            <input class="search-box-keyword" type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
            @if (request('tab'))
                <input type="hidden" name="tab" value="{{ request('tab') }}">
            @endif
        </form>
        <nav class="header-nav">
            <ul class="header-nav-inner">
            {{-- ログイン中 --}}
                @auth
                <li class="header-nav-ttl">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="header-nav-txt">ログアウト</button>
                    </form>
                </li>
                <li class="header-nav-ttl">
                    <a class="header-nav-txt" href="{{ route('mypage') }}">マイページ</a>
                </li>
                <li class="header-nav-sell">
                    <a class="header-nav-txt" href="{{ route('sell') }}">出品</a>
                </li>
                @endauth

                {{-- 非ログイン中 --}}
                @guest
                <li class="header-nav-ttl">
                    <a class="header-nav-txt" href="{{ route('login') }}">ログイン</a>
                </li>
                <li class="header-nav-ttl">
                    <a class="header-nav-txt" href="{{ route('login') }}">マイページ</a>
                </li>
                <li class="header-nav-sell">
                    <a class="header-nav-txt" href="{{ route('login') }}">出品</a>
                </li>
                @endguest
            </ul>
        </nav>
        @endif
    </header>
    @yield('content')
</body>
</html>