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
        {{-- CSS/JavaScript --}}
        @if (app()->isLocal())
            {{-- 開発環境用 --}}
            @vite(['resources/js/app.js', 'resources/css/app.css'])
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
                <link href="{{ secure_asset('build/' . $cssFile) }}" rel="stylesheet">
            @endforeach
            {{-- JavaScript --}}
            @if ($jsFile)
                <script src="{{ secure_asset('build/' . $jsFile) }}" defer></script>
            @endif
        @endif
        {{-- FontAwesome --}}
        <script src="https://kit.fontawesome.com/be9c19f3fa.js" crossorigin="anonymous"></script>
    </head>

    <body class="m-0 block w-full bg-sky-50 p-0 dark:bg-sky-950">
        <header
            class="t-0 fixed top-0 z-50 flex h-20 w-full flex-row items-stretch justify-between bg-sky-700/75 px-5 dark:bg-sky-300/75">
            <div class="my-auto flex">
                <h1 class="flex align-middle text-3xl font-bold text-sky-50 dark:text-sky-950">
                    <a href="{{ url('', null, app()->isProduction()) }}">{{ config('app.name', 'Laravel') }}</a>
                </h1>
            </div>
            <div class="my-auto flex flex-row gap-2">
                @auth
                    @if (Auth::user()->admin_flg)
                        {{-- ユーザー管理 --}}
                        <a class="block text-3xl text-sky-50 dark:text-sky-950"
                            href="{{ url('admin/users', null, app()->isProduction()) }}" title="ユーザー管理">
                            <i class="fa-solid fa-users fa-fw m-auto object-cover"></i>
                        </a>
                        {{-- 商品管理 --}}
                        @if (Auth::user()->user_id != env('DEFAULT_ADMIN_ID', 'ec_admin'))
                            <a class="block text-3xl text-sky-50 dark:text-sky-950"
                                href="{{ url('admin/products', null, app()->isProduction()) }}" title="商品管理">
                                <i class="fa-solid fa-boxes-stacked fa-fw m-auto object-cover"></i>
                            </a>
                        @endif
                    @else
                        {{-- マイページ --}}
                        <a class="block text-3xl text-sky-50 dark:text-sky-950"
                            href="{{ url('mypage', null, app()->isProduction()) }}" title="マイページ">
                            <i class="fa-solid fa-user fa-fw m-auto object-cover"></i>
                        </a>
                        {{-- ショッピングカート --}}
                        <a class="block text-3xl text-sky-50 dark:text-sky-950"
                            href="{{ url('cart', null, app()->isProduction()) }}" title="ショッピングカート">
                            <i class="fa-solid fa-cart-shopping fa-fw m-auto object-cover"></i>
                        </a>
                    @endif
                    {{-- ログアウト --}}
                    <form class="block" method="POST" action="{{ url('logout', null, app()->isProduction()) }}"
                        onsubmit="return common.logout();">
                        @csrf
                        <button class="block text-3xl text-sky-50 dark:text-sky-950" type="submit" title="ログアウト">
                            <i class="fa-solid fa-right-from-bracket fa-fw m-auto object-cover"></i>
                        </button>
                    </form>
                @endauth
            </div>
        </header>
        <main class="mx-auto block w-full py-24 md:w-[95%]">
            {{-- ページタイトル --}}
            <div class="flex w-full py-12">
                <h2 class="mx-auto flex text-center text-3xl font-bold text-sky-950 dark:text-sky-50">
                    @yield('pagetitle')
                </h2>
            </div>
            @if (session('message'))
                <div class="flex w-full flex-col p-4">
                    <p class="text-center text-xl font-bold text-sky-950 dark:text-sky-50">{{ session('message') }}
                    </p>
                </div>
            @endif
            {{-- ページ内ヘッダーメニュー --}}
            @yield('menu')
            <div class="flex w-full flex-col">
                {{-- コンテンツ --}}
                @yield('content')
            </div>
            {{-- ページ内フッターメニュー --}}
            @yield('menu')
        </main>
        <footer class="fixed bottom-0 z-50 flex h-20 w-full bg-sky-700/75 dark:bg-sky-300/75">
            @auth
                {{-- ログインユーザー --}}
                <div class="m-auto flex leading-8">
                    <p class="text-center text-lg font-bold text-sky-50 md:text-xl dark:text-sky-950">
                        {{ Auth::user()->user_name }}さんがログイン中
                    </p>
                </div>
            @endauth
        </footer>
    </body>

    {{-- Script --}}
    @yield('script')

</html>
