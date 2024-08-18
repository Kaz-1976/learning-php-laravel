@extends('layouts.layout')

@section('pagetitle', '新規登録')

@section('content')
    <div class="container m-auto">
        <form method="POST" action="{{ route('register') }}">
            <!-- CSRF -->
            @csrf

            <!-- フラグ -->
            <x-text-input type="hidden" name="enable_flg" :value="1" />
            <x-text-input type="hidden" name="admin_flg" :value="0" />

            <!-- ユーザーID -->
            <div class="mt-4">
                <x-input-label for="user_id" :value="__('ID')" />
                <x-text-input id="user_id" class="block mt-1 w-full" type="text" name="user_id" :value="old('user_id')"
                    required autofocus autocomplete="user_id" placeholder="EcTaro" />
                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
            </div>

            <!-- 氏名（漢字） -->
            <div class="mt-4">
                <x-input-label for="user_name" :value="__('氏名（漢字）')" />
                <x-text-input id="user_name" class="block mt-1 w-full" type="text" name="user_name" :value="old('user_name')"
                    required autofocus autocomplete="user_name" placeholder="イーシー太郎" />
                <x-input-error :messages="$errors->get('user_name')" class="mt-2" />
            </div>

            <!-- 氏名（かな） -->
            <div class="mt-4">
                <x-input-label for="user_kana" :value="__('氏名（かな）')" />
                <x-text-input id="user_kana" class="block mt-1 w-full" type="text" name="user_kana" :value="old('user_kana')"
                    required autofocus autocomplete="user_kana" placeholder="いーしーたろう" />
                <x-input-error :messages="$errors->get('user_kana')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="email" placeholder="ec-taro@example.local" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" placeholder="ABCabc0123!@#$%^&*" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" placeholder="ABCabc0123!@#$%^&*" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-l text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection
