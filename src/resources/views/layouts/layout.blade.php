<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Common -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>@yield('PageTitle')：{{ config('app.name', 'Laravel') }}</title>

    <!-- CSS -->
    <link rel="stylesheet" href="/css/common.css">

    <!-- Script -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header>
        <div class="ec-header-title-wrapper">
            <h1><a href="/">{{ config('app.name', 'Laravel') }}</a></h1>
        </div>
        <div class="ec-header-link-wrapper">
            <ul class="ec-header-link">
                <li class="ec-header-link-item">
                    <a class="ec-icon-button" href="./cart.php">
                        <i class="fa-solid fa-cart-shopping" alt="ショッピングカート"></i>
                    </a>
                </li>
                <li class="ec-header-link-item">
                    <form id="form-logout" action="./index.php" method="POST">
                        @csrf
                        <button class="ec-icon-button" type="submit" form="form-logout" name="action" value="logout">
                            <i class="fa-solid fa-right-from-bracket fa-2xl" alt="ログアウト"></i>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </header>
    <div class="ec-header-margin"></div>
    <div class="wrapper">
        @yield('Content')
    </div>
    <div class="ec-footer-margin"></div>
    <footer>
        <div class="ec-footer-item">
            <p class="ec-footer-string">{{ Auth::user()->name }}さんがログイン中</p>
        </div>
    </footer>
</body>

</html>
