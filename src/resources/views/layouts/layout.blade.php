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
        class="fixed top-0 z-50 flex flex-row justify-between items-stretch t-0 w-full h-20 px-5 bg-sky-700/80 dark:bg-sky-300/80">
        <div class="flex my-auto">
            <h1 class="flex text-4xl text-sky-50 dark:text-sky-950 font-bold align-middle leading-5">
                <a href="{{ route('ec_site.index') }}">{{ config('app.name', 'Laravel') }}</a>
            </h1>
        </div>
        <div class="flex">
            <ul class="flex my-auto list-inside gap-2">
                @auth
                @if (Auth::user()->admin_flg)
                <li class="inline m-auto text-xl">
                    <a href="{{ route('users.index') }}" title="ユーザー管理">
                        <i class="fa-solid fa-users fa-2xl w-full h-full text-sky-50 dark:text-sky-950"></i>
                    </a>
                </li>
                @if (Auth::user()->user_id != env('DEFAULT_ADMIN_ID','ec_admin'))
                <li class="inline m-auto text-xl">
                    <a href="{{ route('products.index') }}" title="商品管理">
                        <i class="fa-solid fa-boxes-stacked fa-2xl w-full h-full text-sky-50 dark:text-sky-950"></i>
                    </a>
                </li>
                @endif
                @else
                <li class="inline m-auto text-xl">
                    <a href="{{ route('cart.index') }}" title="ショッピングカート">
                        <i class="w-full h-full text-sky-50 dark:text-sky-950 fa-solid fa-cart-shopping fa-2xl"></i>
                    </a>
                </li>
                @endif
                <li class="inline m-auto text-xl">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="ログアウト">
                            <i
                                class="w-full h-full text-sky-50 dark:text-sky-950 fa-solid fa-right-from-bracket fa-2xl"></i>
                        </button>
                    </form>
                </li>
                @endauth
            </ul>
        </div>
    </header>
    <div class="block h-20 bg-sky-100 dark:bg-sky-950"></div>
    <main class="w-full max-w-screen-xl mx-auto h-screen">
        <div class="flex flex-col">
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
        </div>
    </main>
    <div class="block h-20 bg-sky-100 dark:bg-sky-950"></div>
    <footer class="fixed z-50 flex bottom-0 w-full h-20 bg-sky-700/80 dark:bg-sky-300/80">
        @auth
        <div class="flex m-auto leading-8">
            <p class="text-lg md:text-xl text-center text-sky-50 dark:text-sky-950 font-bold">
                {{ Auth::user()->user_name }}さんがログイン中
            </p>
        </div>
        @endauth
    </footer>
</body>

</html>