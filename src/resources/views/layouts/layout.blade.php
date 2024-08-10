<!DOCTYPE html>
<html class="h-full bg-white" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Common -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>@yield('pagetitle')：{{ config('app.name', 'Laravel') }}</title>

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/be9c19f3fa.js" crossorigin="anonymous"></script>

    <!-- Script -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full">
    <header class="flex flex-row items-stretch sticky t-0 w-full h-20 px-5 bg-sky-300">
        <div class="flex my-auto">
            <h1 class="flex text-4xl font-bold align-middle leading-5">
                <a href="{{ route('ec_site.index') }}">{{ config('app.name', 'Laravel') }}</a>
            </h1>
        </div>
        <div class="flex">
            <ul class="ec-header-link">
                @auth
                    @if (!Auth::user()->admin_flg)
                    <li class="ec-header-link-item">
                        <a class="ec-icon-button" href="{{ route('cartdetails.index') }}">
                            <i class="fa-solid fa-cart-shopping" alt="ショッピングカート"></i>
                        </a>
                    </li>
                    @endif
                    <li class="ec-header-link-item">
                        <a class="ec-icon-button" href="{{ route('auth.logout') }}">
                            <i class="fa-solid fa-right-from-bracket fa-2xl" alt="ログアウト"></i>
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </header>
    <div class="h-20"></div>
    <div class="container mx-auto">
        <div class="container mx-auto">
            <h2 class="text-3xl text-center font-bold">@yield('pagetitle')</h2>
        </div>
        @yield('content')
    </div>
    <div class="h-20"></div>
    <footer class="fixed bottom-0 w-full h-20 bg-sky-300">
        <div class="leading-8">
            @auth
            <p class="text-3xl text-center font-bold">{{ Auth::user()->user_name }}さんがログイン中</p>
            @endauth
        </div>
    </footer>
</body>

</html>
