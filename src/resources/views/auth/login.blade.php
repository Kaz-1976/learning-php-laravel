@extends('layouts.layout')

@section('pagetitle', 'ログイン')

@section('content')
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="container w-auto m-auto mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" method="POST" action="{{ url('/login', null, $is_production) }}">
            @csrf

            <!-- User ID -->
            <div>
                <x-input-label for="user_id" :value="__('ID')" />
                <x-text-input id="user_id" class="block mt-1 w-full" type="text" name="user_id" :value="old('user_id')" required
                    autofocus autocomplete="user_id" />
                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                        name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between">

                @if (Route::has('password.request'))
                    <a class="underline text-m text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        href="{{ url('/forgot-password', null, $is_production) }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button class="ms-3 text-m">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
        @if (Route::has('register'))
            <div class="container my-4 text-center text-gray-600 dark:text-gray-400">
                アカウントをお持ちでない方は
                <a class="underline font-bold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ url('/register', null, $is_production) }}">
                    {{ __('Register') }}
                </a>
            </div>
        @endif
    </div>
@endsection
