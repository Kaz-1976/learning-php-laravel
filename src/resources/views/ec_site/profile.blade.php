@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '登録情報')

{{-- ページコンテンツ --}}
@section('content')
    <div class="flex flex-col gap-4">
        <form class="flex flex-col gap-1 p-4 border-solid border-2 rounded-lg border-sky-950 dark:border-sky-50"
            id="register" action="@generateUrl('mypage/profile/update')" method="POST">
            @csrf
            {{-- ユーザーID --}}
            <div>
                <x-input-label for="register-user-id" :value="__('ID')" />
                <x-text-input class="block mt-1 w-full" type="text" id="register-user-id" name="user_id" :value="$ec_user->user_id"
                    required autofocus autocomplete="user_id" placeholder="EcTaro" />
                @if (old('register') == '1')
                    <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                @endif
            </div>
            {{-- 氏名（漢字） --}}
            <div>
                <x-input-label for="register-user-name" :value="__('氏名（漢字）')" />
                <x-text-input class="block mt-1 w-full" type="text" id="register-user-name" name="user_name"
                    :value="$ec_user->user_name" required autofocus autocomplete="user_name" placeholder="イーシー太郎" />
                @if (old('register') == '1')
                    <x-input-error :messages="$errors->get('user_name')" class="mt-2" />
                @endif
            </div>
            {{-- 氏名（かな） --}}
            <div>
                <x-input-label for="register-user-kana" :value="__('氏名（かな）')" />
                <x-text-input class="block mt-1 w-full" type="text" id="register-user-kana" name="user_kana"
                    :value="$ec_user->user_kana" required autofocus autocomplete="user_kana" placeholder="いーしーたろう" />
                @if (old('register') == '1')
                    <x-input-error :messages="$errors->get('user_kana')" class="mt-2" />
                @endif
            </div>
            {{-- メールアドレス --}}
            <div>
                <x-input-label for="register-email" :value="__('Email')" />
                <x-text-input class="block mt-1 w-full" type="text" id="register-email" name="email" :value="$ec_user->email"
                    required autofocus autocomplete="email" placeholder="ec-taro@example.local" />
                @if (old('register') == '1')
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                @endif
            </div>
            {{-- パスワード --}}
            <div>
                <x-input-label for="register-password" :value="__('Password')" />
                <x-text-input class="block mt-1 w-full" type="password" id="register-password" name="password" required
                    autocomplete="new-password" placeholder="ABCabc0123!@#$%^&*_" />
                @if (old('register') == '1')
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                @endif
            </div>
            {{-- パスワード再入力 --}}
            <div>
                <x-input-label for="register-password-confirm" :value="__('Confirm Password')" />
                <x-text-input class="block mt-1 w-full" type="password" id="register-password-confirm"
                    name="password_confirmation" required autocomplete="new-password" placeholder="ABCabc0123!@#$%^&*_" />
                @if (old('register') == '1')
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                @endif
            </div>
            <div class="flex flex-col md:flex-row justify-between gap-2">
                <div class="flex flex-row basis-full gap-2 h-auto">
                    <div class="flex flex-row basis-1/2 my-auto">
                        <x-secondary-button class="flex basis-full" type='reset' name="reset" :value="1">
                            <span class="flex m-auto text-base md:text-xl text-center font-bold">{{ __('リセット') }}</span>
                        </x-secondary-button>
                    </div>
                    <div class="flex flex-row basis-1/2 my-auto">
                        <x-primary-button class="flex basis-full" form="register" name="register" :value="1">
                            <span class="flex m-auto text-base md:text-xl text-center font-bold">{{ __('Register') }}</span>
                        </x-primary-button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')

@endsection
