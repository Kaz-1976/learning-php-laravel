@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', 'ユーザー管理')

{{-- ページコンテンツ --}}
@section('content')
    <div class="container flex flex-col gap-4">
        <div class="container p-4 border-solid border-2 border-sky-50 rounded-lg">
            <form id="register" action="{{ route('users.store') }}" method="POST">
                @csrf
                {{-- ユーザーID --}}
                <div>
                    <x-input-label for="register-user-id" :value="__('ID')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="register-user-id" name="user_id"
                        :value="old('user_id')" required autofocus autocomplete="user_id" placeholder="EcTaro" />
                    <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                </div>
                {{-- 氏名（漢字） --}}
                <div>
                    <x-input-label for="register-user-name" :value="__('氏名（漢字）')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="register-user-name" name="user_name"
                        :value="old('user_name')" required autofocus autocomplete="user_name" placeholder="イーシー太郎" />
                    <x-input-error :messages="$errors->get('user_name')" class="mt-2" />
                </div>
                {{-- 氏名（かな） --}}
                <div>
                    <x-input-label for="register-user-kana" :value="__('氏名（かな）')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="register-user-kana" name="user_kana"
                        :value="old('user_kana')" required autofocus autocomplete="user_kana" placeholder="いーしーたろう" />
                    <x-input-error :messages="$errors->get('user_kana')" class="mt-2" />
                </div>
                {{-- メールアドレス --}}
                <div>
                    <x-input-label for="register-email" :value="__('Email')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="register-email" name="email"
                        :value="old('email')" required autofocus autocomplete="email" placeholder="ec-taro@example.local" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                {{-- パスワード --}}
                <div>
                    <x-input-label for="register-password" :value="__('Password')" />
                    <x-text-input class="block mt-1 w-full" type="password" id="register-password" name="password" required
                        autocomplete="new-password" placeholder="ABCabc0123!@#$%^&*" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                {{-- パスワード再入力 --}}
                <div>
                    <x-input-label for="register-password-confirm" :value="__('Confirm Password')" />
                    <x-text-input class="block mt-1 w-full" type="password" id="register-password-confirm"
                        name="password_confirmation" required autocomplete="new-password"
                        placeholder="ABCabc0123!@#$%^&*" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <div class="py-4 flex flex-row justify-between">
                    <div class="my-auto flex flex-row basis-1/4">
                        <x-text-input class="w-8 h-8" type="checkbox" id="register-enable" name="enable_flg"
                            :value="old('enable_flg')" required autofocus autocomplete="enable_flg" />
                        <x-input-label class="my-auto pl-2 flex" for="register-enable" :value="__('有効')" />
                        <x-input-error :messages="$errors->get('enable_flg')" class="mt-2" />
                    </div>
                    <div class="my-auto flex flex-row basis-1/4">
                        <x-text-input class="w-8 h-8" type="checkbox" id="register-admin" name="admin_flg"
                            :value="old('admin_flg')" required autofocus autocomplete="admin_flg" />
                        <x-input-label class="my-auto pl-2 flex" for="register-admin" :value="__('管理者')" />
                        <x-input-error :messages="$errors->get('enable_flg')" class="mt-2" />
                    </div>
                    <div class="my-auto flex flex-row basis-2/4">
                        <x-primary-button class="flex basis-full">
                            <span class="flex m-auto text-2xl text-center font-bold">{{ __('Register') }}</span>
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
        <div class="container">
            @foreach ($ec_users as $ec_user)
                <div
                    class="w-full p-4 flex flex-row basis-full gap-2 border-b-2 border-sky-50 {{ $ec_user->enable_flg ? ($ec_user->admin_flg ? 'bg-sky-800' : 'bg-sky-700') : 'bg-sky-900' }}">
                    <form class="flex flex-row basis-full gap-2" id="update-users-{{ $ec_user->id }}"
                        action="{{ route('users.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $ec_user->id }}" />
                        <input type="hidden" name="enable_flg" value="{{ $ec_user->enable_flg }}" />
                        <input type="hidden" name="admin_flg" value="{{ $ec_user->admin_flg }}" />
                        <div class="flex flex-col basis-4/5 gap-1">
                            <div class="block">
                                <x-input-label for="update-user-id-{{ $ec_user->id }}" :value="__('ID')" />
                                <x-text-input class="block mt-1 w-full" type="text"
                                    id="update-user-id-{{ $ec_user->id }}" name="user_id" :value="$ec_user->user_id"
                                    :disabled="$ec_user->user_id === env('DEFAULT_ADMIN_ID', 'ec_admin')" required autofocus autocomplete="user_id" placeholder="EcTaro" />
                                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                            </div>
                            <div class="block">
                                <x-input-label for="update-user-name-{{ $ec_user->id }}" :value="__('氏名（漢字）')" />
                                <x-text-input class="block mt-1 w-full" type="text"
                                    id="update-user-name-{{ $ec_user->id }}" name="user_name" :value="$ec_user->user_name"
                                    required autofocus autocomplete="user_name" placeholder="イーシー太郎" />
                                <x-input-error :messages="$errors->get('user_name')" class="mt-2" />
                            </div>
                            <div class="block">
                                <x-input-label for="update-user-kana-{{ $ec_user->id }}" :value="__('氏名（かな）')" />
                                <x-text-input class="block mt-1 w-full" type="text"
                                    id="update-user-kana-{{ $ec_user->id }}" name="user_kana" :value="$ec_user->user_kana"
                                    required autofocus autocomplete="user_kana" placeholder="いーしーたろう" />
                                <x-input-error :messages="$errors->get('user_kana')" class="mt-2" />
                            </div>
                            <div class="block">
                                <x-input-label for="update-email-{{ $ec_user->id }}" :value="__('Email')" />
                                <x-text-input class="block mt-1 w-full" type="text"
                                    id="update-email-{{ $ec_user->id }}" name="email" :value="$ec_user->email" required
                                    autofocus autocomplete="email" placeholder="ec-taro@example.local" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div class="block">
                                <x-input-label for="update-password-{{ $ec_user->id }}" :value="__('Password')" />
                                <x-text-input class="block mt-1 w-full" type="password"
                                    id="update-password-{{ $ec_user->id }}" name="password" autocomplete="new-password"
                                    placeholder="ABCabc0123!@#$%^&*" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div class="block">
                                <x-input-label for="update-password-confirm-{{ $ec_user->id }}" :value="__('Confirm Password')" />
                                <x-text-input class="block mt-1 w-full" type="password"
                                    id="update-password-confirm-{{ $ec_user->id }}" name="password_confirmation"
                                    autocomplete="new-password" placeholder="ABCabc0123!@#$%^&*" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        </div>
                        <div class="flex flex-col basis-1/5 gap-2">
                            <div class="flex basis-full">
                                @if ($ec_user->user_id != env('DEFAULT_ADMIN_ID', 'ec_admin'))
                                    <x-primary-button class="w-full" name="enable">
                                        <span
                                            class="flex m-auto text-2xl text-center font-bold">{{ __($ec_user->enable_flg ? '無効' : '有効') }}</span>
                                    </x-primary-button>
                                @endif
                            </div>
                            <div class="flex basis-full">
                                @if ($ec_user->user_id != env('DEFAULT_ADMIN_ID', 'ec_admin'))
                                    <x-primary-button class="w-full" name="admin">
                                        <span
                                            class="flex m-auto text-2xl text-center font-bold">{{ __($ec_user->admin_flg ? '一般' : '管理者') }}</span>
                                    </x-primary-button>
                                @endif
                            </div>
                            <div class="flex basis-full">
                                <x-primary-button class="w-full" name="update">
                                    <span class="flex m-auto text-2xl text-center font-bold">{{ __('更新') }}</span>
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection
