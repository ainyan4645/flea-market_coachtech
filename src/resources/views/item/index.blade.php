<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECHフリマ</title>
    <!-- フォント -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Noto+Serif+JP:wght@200..900&display=swap" rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/item/index.css') }}">
</head>
<body>
    <header class="header__inner">
        <a href="" class="header-logo__inner">
            <img src="{{ asset('img/logo.svg') }}" alt="header-logo" class="header-logo_img">
        </a>
        <form class="search-box" action="" method="">
            <input class="search-box__keyword" type="text" name="keyword" placeholder="なにをお探しですか？">
        </form>
        <nav>
            <ul class="header-nav">
                <li class="header-nav__ttl__black">
                    <a href="">ログアウト</a>
                </li>
                <li class="header-nav__ttl__black">
                    <a href="">マイページ</a>
                </li>
                <li class="header-nav__ttl__white">
                    <a href="">出品</a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="tabs">
        <!-- タブ1 -->
        <input type="radio" name="tabset" class="tab-radio" id="tab-recommend" checked>
        <label class="tab-label" for="tab-recommend">おすすめ</label>
        <div class="tab-content">
            <div class="content__grid">
            <article class="content__card">
                <div class="content__img__inner">
                <img src="" alt="商品画像">
                </div>
                <p class="content__ttl">商品名_一覧</p>
            </article>
            </div>
        </div>

        <!-- タブ2 -->
        <input type="radio" name="tabset" class="tab-radio" id="tab-mylist">
        <label class="tab-label" for="tab-mylist">マイリスト</label>
        <div class="tab-content">
            <div class="content__grid">
            <article class="content__card">
                <div class="content__img__inner">
                <img src="" alt="商品画像">
                </div>
                <p class="content__ttl">商品名_マイリスト</p>
            </article>
            </div>
        </div>
        </div>
    </main>
</body>
</html>