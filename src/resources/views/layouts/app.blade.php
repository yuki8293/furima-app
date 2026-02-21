<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <a class="header__logo" href="/">
                    <img src="{{ asset('images/coachtech-logo.png') }}" alt="coachtech">
                </a>

                <form action="{{ route('items.index') }}" method="GET">
                    <input type="text" name="keyword"
                        placeholder="商品を検索"
                        value="{{ request('keyword') }}">
                    <button type="submit">検索</button>
                </form>

                <nav>
                    <ul class="header-nav">

                        @auth
                        <li class="header-nav__item">
                            <form action="/logout" method="post">
                                @csrf
                                <button class="header-nav__button">ログアウト</button>
                            </form>
                        </li>

                        <li class="header-nav__item">
                            <a class="header-nav__link" href="{{ route('mypage') }}">
                                マイページ
                            </a>
                        </li>

                        <li class="header-nav__item">
                            <a class="header-nav__link header-nav__sell" href="{{ route('sell.create') }}">
                                出品
                            </a>
                        </li>
                        @endauth

                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>