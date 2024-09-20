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

    <!-- Script -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Script -->
    <script src="{{ asset('js/common.js') }}"></script>

    <!-- CSS -->
    <style>
        * {
            box-sizing: border-box;
        }
    </style>
</head>

<body class="w-full bg-sky-50 dark:bg-sky-950">
    <header
        class="fixed top-0 z-50 flex flex-row justify-between items-stretch t-0 w-full h-20 px-5 bg-sky-700/75 dark:bg-sky-300/75">
        <div class="flex my-auto">
            <h1 class="flex text-3xl text-sky-50 dark:text-sky-950 font-bold align-middle leading-5">
                <a href="{{ route('ec_site.index') }}">{{ config('app.name', 'Laravel') }}</a>
            </h1>
        </div>
        <ul class="flex flex-row my-auto list-inside gap-3">
            @auth
            @if (Auth::user()->admin_flg)
            <li class="flex w-8 h-8 m-auto">
                <a class="flex w-full h-full m-auto" href="{{ route('users.index') }}" title="ユーザー管理">
                    <i class="fa-solid fa-users fa-xl w-full h-full object-cover text-sky-50 dark:text-sky-950"></i>
                </a>
            </li>
            @if (Auth::user()->user_id != env('DEFAULT_ADMIN_ID','ec_admin'))
            <li class="flex w-8 h-8 m-auto">
                <a class="flex w-full h-full m-auto" href="{{ route('products.index') }}" title="商品管理">
                    <i
                        class="fa-solid fa-boxes-stacked fa-xl w-full h-full object-cover text-sky-50 dark:text-sky-950"></i>
                </a>
            </li>
            @endif
            @else
            <li class="flex w-8 h-8 m-auto">
                <a class="flex w-full h-full m-auto" href="{{ route('cart.index') }}" title="ショッピングカート">
                    <i
                        class="fa-solid fa-cart-shopping fa-xl w-full h-full object-cover text-sky-50 dark:text-sky-950"></i>
                </a>
            </li>
            @endif
            <li class="flex w-8 h-8 m-auto">
                <form class="flex w-full h-full m-auto" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex w-full h-full m-auto" type="submit" title="ログアウト">
                        <i
                            class="fa-solid fa-right-from-bracket fa-xl w-full h-full object-cover text-sky-50 dark:text-sky-950 fa-solid"></i>
                    </button>
                </form>
            </li>
            @endauth
        </ul>
    </header>
    <div class="block w-full h-20 bg-sky-100 dark:bg-sky-950"></div>
    <main class="flex flex-col basis-full">
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