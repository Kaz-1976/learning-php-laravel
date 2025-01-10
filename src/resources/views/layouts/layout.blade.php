<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        {{-- Common --}}
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- Title --}}
        <title>@yield('pagetitle')：{{ config('app.name', 'Laravel') }}</title>
        {{-- FontAwesome --}}
        <script src="https://kit.fontawesome.com/be9c19f3fa.js" crossorigin="anonymous"></script>
        {{-- Vite --}}
        @if (app()->isLocal())
            {{-- 開発環境用 --}}
            @vite(['resources/js/app.js', 'resources/css/app.css'])
            <script src="{{ asset('js/common.js') }}" defer></script>
            <link rel="stylesheet" href="{{ asset('css/common.css') }}">
        @else
            {{-- 本番環境用 --}}
            @php
                // マニフェストからCSS/JSを抽出
                $manifestPath = public_path('build/manifest.json');
                if (file_exists($manifestPath)) {
                    $manifest = json_decode(file_get_contents($manifestPath), true);
                } else {
                    throw new Exception('The Vite manifest file does not exist.');
                }
                $jsFile = $manifest['resources/js/app.js']['file'] ?? null;
                $cssFiles = $manifest['resources/js/app.js']['css'] ?? [];
            @endphp
            {{-- CSS --}}
            @foreach ($cssFiles as $cssFile)
                <link rel="stylesheet" href="{{ secure_asset('build/' . $cssFile) }}">
            @endforeach
            <link rel="stylesheet" href="{{ secure_asset('css/common.css') }}">
            {{-- Script --}}
            @if ($jsFile)
                <script src="{{ secure_asset('build/' . $jsFile) }}" defer></script>
            @endif
            <script src="{{ secure_asset('js/common.js') }}" defer></script>
        @endif
    </head>

    <body class="block w-full bg-sky-50 dark:bg-sky-950">
        <header
            class="fixed top-0 z-50 flex flex-row justify-between items-stretch t-0 w-full h-20 px-5 bg-sky-700/75 dark:bg-sky-300/75">
            <div class="flex my-auto">
                <h1 class="flex text-3xl text-sky-50 dark:text-sky-950 font-bold align-middle">
                    <a href="{{ url('/', null, app()->isProduction()) }}">{{ config('app.name', 'Laravel') }}</a>
                </h1>
            </div>
            <div class="flex flex-row gap-2 my-auto">
                @auth
                    @if (Auth::user()->admin_flg)
                        {{-- ユーザー管理 --}}
                        <a class="block text-3xl text-sky-50 dark:text-sky-950"
                            href="{{ url('/admin/users', null, app()->isProduction()) }}" title="ユーザー管理">
                            <i class="fa-solid fa-users fa-fw m-auto object-cover"></i>
                        </a>
                        {{-- 商品管理 --}}
                        @if (Auth::user()->user_id != env('DEFAULT_ADMIN_ID', 'ec_admin'))
                            <a class="block text-3xl text-sky-50 dark:text-sky-950"
                                href="{{ url('/admin/products', null, app()->isProduction()) }}" title="商品管理">
                                <i class="fa-solid fa-boxes-stacked fa-fw m-auto object-cover"></i>
                            </a>
                        @endif
                    @else
                        {{-- マイページ --}}
                        <a class="block text-3xl text-sky-50 dark:text-sky-950"
                            href="{{ url('/mypage', null, app()->isProduction()) }}" title="マイページ">
                            <i class="fa-solid fa-user fa-fw m-auto object-cover"></i>
                        </a>
                        {{-- ショッピングカート --}}
                        <a class="block text-3xl text-sky-50 dark:text-sky-950"
                            href="{{ url('/cart', null, app()->isProduction()) }}" title="ショッピングカート">
                            <i class="fa-solid fa-cart-shopping fa-fw m-auto object-cover"></i>
                        </a>
                    @endif
                    {{-- ログアウト --}}
                    <form class="block" method="POST" action="{{ url('/logout', null, app()->isProduction()) }}">
                        @csrf
                        <button class="block text-3xl text-sky-50 dark:text-sky-950" type="submit" title="ログアウト">
                            <i class="fa-solid fa-right-from-bracket fa-fw m-auto object-cover"></i>
                        </button>
                    </form>
                @endauth
            </div>
        </header>
        <main class="block w-full md:w-[95%] mx-auto py-24">
            <div class="flex w-full py-12">
                <h2 class="flex mx-auto text-3xl text-center font-bold text-sky-950 dark:text-sky-50">@yield('pagetitle')
                </h2>
            </div>
            @if (session('message'))
                <div class="flex flex-col w-full p-4">
                    <p class="text-xl text-center font-bold text-sky-950 dark:text-sky-50">{{ session('message') }}
                    </p>
                </div>
            @endif
            <div class="flex flex-col w-full">
                @yield('content')
            </div>
        </main>
        <footer class="fixed z-50 flex bottom-0 w-full h-20 bg-sky-700/75 dark:bg-sky-300/75">
            @auth
                {{-- ログインユーザー --}}
                <div class="flex m-auto leading-8">
                    <p class="text-lg md:text-xl text-center font-bold text-sky-50 dark:text-sky-950">
                        {{ Auth::user()->user_name }}さんがログイン中
                    </p>
                </div>
            @endauth
        </footer>
    </body>

</html>
