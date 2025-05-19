@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '登録情報')

{{-- ページメニュー --}}
@section('menu')
    <x-link-button-box>
        <x-link-button class="basis-full" link-type="link" link-to="{{ url('mypage', null, app()->isProduction()) }}">
            マイページ
        </x-link-button>
    </x-link-button-box>
@endsection

{{-- ページコンテンツ --}}
@section('content')
    <div class="flex flex-col gap-4">
        <form class="flex flex-col gap-1 rounded-lg border-2 border-solid border-sky-950 p-4 dark:border-sky-50"
            id="register" action="{{ url('mypage/profile/update', null, app()->isProduction()) }}" method="POST">
            @csrf
            {{-- ユーザーID --}}
            <div>
                <x-input-label for="register-user-id" :value="__('ID')" />
                <x-text-input class="mt-1 block w-full" id="register-user-id" name="user_id" type="text" :value="$ec_user->user_id"
                    required autofocus autocomplete="user_id" placeholder="EcTaro" />
                @if (old('register') == '1')
                    <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                @endif
            </div>
            {{-- 氏名（漢字） --}}
            <div>
                <x-input-label for="register-user-name" :value="__('氏名（漢字）')" />
                <x-text-input class="mt-1 block w-full" id="register-user-name" name="user_name" type="text"
                    :value="$ec_user->user_name" required autofocus autocomplete="user_name" placeholder="イーシー太郎" />
                @if (old('register') == '1')
                    <x-input-error class="mt-2" :messages="$errors->get('user_name')" />
                @endif
            </div>
            {{-- 氏名（かな） --}}
            <div>
                <x-input-label for="register-user-kana" :value="__('氏名（かな）')" />
                <x-text-input class="mt-1 block w-full" id="register-user-kana" name="user_kana" type="text"
                    :value="$ec_user->user_kana" required autofocus autocomplete="user_kana" placeholder="いーしーたろう" />
                @if (old('register') == '1')
                    <x-input-error class="mt-2" :messages="$errors->get('user_kana')" />
                @endif
            </div>
            {{-- メールアドレス --}}
            <div>
                <x-input-label for="register-email" :value="__('Email')" />
                <x-text-input class="mt-1 block w-full" id="register-email" name="email" type="text" :value="$ec_user->email"
                    required autofocus autocomplete="email" placeholder="ec-taro@example.local" />
                @if (old('register') == '1')
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                @endif
            </div>
            {{-- パスワード --}}
            <div>
                <x-input-label for="register-password" :value="__('Password')" />
                <x-text-input class="mt-1 block w-full" id="register-password" name="password" type="password"
                    autocomplete="new-password" placeholder="ABCabc0123!@#$%^&*_" />
                @if (old('register') == '1')
                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                @endif
            </div>
            {{-- パスワード再入力 --}}
            <div>
                <x-input-label for="register-password-confirm" :value="__('Confirm Password')" />
                <x-text-input class="mt-1 block w-full" id="register-password-confirm" name="password_confirmation"
                    type="password" autocomplete="new-password" placeholder="ABCabc0123!@#$%^&*_" />
                @if (old('register') == '1')
                    <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                @endif
            </div>
            <div class="flex flex-col justify-between gap-2 md:flex-row">
                <div class="flex h-auto basis-full flex-row gap-2">
                    <div class="my-auto flex basis-1/2 flex-row">
                        <x-secondary-button class="flex basis-full" name="reset" type='reset' :value="1">
                            <span class="m-auto flex text-center text-base font-bold md:text-xl">{{ __('リセット') }}</span>
                        </x-secondary-button>
                    </div>
                    <div class="my-auto flex basis-1/2 flex-row">
                        <x-primary-button class="flex basis-full" name="register" form="register" :value="1">
                            <span class="m-auto flex text-center text-base font-bold md:text-xl">{{ __('更新') }}</span>
                        </x-primary-button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')

@endsection
