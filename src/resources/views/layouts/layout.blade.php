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
    <title>@yield('pagetitle')：{{ config('app.name', 'Laravel') }}</title>

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/be9c19f3fa.js" crossorigin="anonymous"></script>

    <!-- Vite -->
	@if (app()->environment('local'))
        <!-- 開発環境用 -->
        @vite(['resources/js/app.js', 'resources/css/app.css'])
	@else
        <!-- 本番環境用 -->
        @php
        	$manifestPath = public_path('build/manifest.json');
            if (file_exists($manifestPath)) {
                $manifest = json_decode(file_get_contents($manifestPath), true);
            } else {
                throw new Exception('The Vite manifest file does not exist.');
            }
            $jsFile = $manifest['resources/js/app.js']['file'] ?? null;
            $cssFiles = $manifest['resources/js/app.js']['css'] ?? [];
        @endphp
        @foreach ($cssFiles as $cssFile)
            <link rel="stylesheet" href="{{ secure_asset('build/' . $cssFile) }}">
        @endforeach
        @if ($jsFile)
            <script src="{{ secure_asset('build/' . $jsFile) }}" defer></script>
        @endif
    @endif
</head>

<body class="block w-full bg-sky-50 dark:bg-sky-950">
    <header
        class="fixed top-0 z-50 flex flex-row justify-between items-stretch t-0 w-full h-20 px-5 bg-sky-700/75 dark:bg-sky-300/75">
        <div class="flex my-auto">
            <h1 class="flex text-3xl text-sky-50 dark:text-sky-950 font-bold align-middle">
                <a href="{{ route('ec_site.index') }}">{{ config('app.name', 'Laravel') }}</a>
            </h1>
        </div>
        <div class="flex flex-row gap-2 my-auto">
            @auth
            @if (Auth::user()->admin_flg)
                <a class="block text-3xl text-sky-50 dark:text-sky-950" href="{{ route('users.index') }}" title="ユーザー管理">
                    <i class="fa-solid fa-users fa-fw m-auto object-cover"></i>
                </a>
                @if (Auth::user()->user_id != env('DEFAULT_ADMIN_ID','ec_admin'))
                    <a class="block text-3xl text-sky-50 dark:text-sky-950" href="{{ route('products.index') }}" title="商品管理">
                        <i class="fa-solid fa-boxes-stacked fa-fw m-auto object-cover"></i>
                    </a>
                @endif
            @else
                <a class="block text-3xl text-sky-50 dark:text-sky-950" href="{{ route('cart.index') }}" title="ショッピングカート">
                    <i class="fa-solid fa-cart-shopping fa-fw m-auto object-cover"></i>
                </a>
            @endif
            <form class="block" method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="block text-3xl text-sky-50 dark:text-sky-950" type="submit" title="ログアウト">
                    <i class="fa-solid fa-right-from-bracket fa-fw m-auto object-cover"></i>
                </button>
            </form>
            @endauth
        </div>
    </header>
    <div class="block w-full h-20 bg-sky-100 dark:bg-sky-950"></div>
    <main class="flex flex-col basis-[90%]">
        <div class="flex mx-auto p-4">
            <h2 class="text-3xl text-center font-bold text-sky-950 dark:text-sky-50">@yield('pagetitle')</h2>
        </div>
        @if (session('message'))
            <div class="flex flex-col w-full p-4">
                <p class="text-xl text-center font-bold text-sky-950 dark:text-sky-50">{{ session('message') }}</p>
            </div>
        @endif
        <div class="flex flex-col w-full p-4">
            @yield('content')
        </div>
    </main>
    <div class="block w-full h-20 bg-sky-100 dark:bg-sky-950"></div>
    <footer class="fixed z-50 flex bottom-0 w-full h-20 bg-sky-700/75 dark:bg-sky-300/75">
        @auth
            <div class="flex m-auto leading-8">
                <p class="text-lg md:text-xl text-center font-bold text-sky-50 dark:text-sky-950">
                    {{ Auth::user()->user_name }}さんがログイン中
                </p>
            </div>
        @endauth
    </footer>
</body>

</html>
