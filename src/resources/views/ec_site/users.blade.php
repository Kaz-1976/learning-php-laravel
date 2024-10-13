@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', 'ユーザー管理')

{{-- ページコンテンツ --}}
@section('content')
    <div class="container flex flex-col gap-4">
        <div class="container p-4 border-solid border-2 rounded-lg border-sky-950 dark:border-sky-50">
            <form id="register" action="{{ url('ec_site/users/store', null, $is_production) }}" method="POST">
                @csrf
                {{-- ユーザーID --}}
                <div>
                    <x-input-label for="register-user-id" :value="__('ID')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="register-user-id" name="user_id"
                        :value="old('register') == '1' ? old('user_id') : ''" required autofocus autocomplete="user_id" placeholder="EcTaro" />
                    @if (old('register') == '1')
                        <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                    @endif
                </div>
                {{-- 氏名（漢字） --}}
                <div>
                    <x-input-label for="register-user-name" :value="__('氏名（漢字）')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="register-user-name" name="user_name"
                        :value="old('register') == '1' ? old('user_name') : ''" required autofocus autocomplete="user_name" placeholder="イーシー太郎" />
                    @if (old('register') == '1')
                        <x-input-error :messages="$errors->get('user_name')" class="mt-2" />
                    @endif
                </div>
                {{-- 氏名（かな） --}}
                <div>
                    <x-input-label for="register-user-kana" :value="__('氏名（かな）')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="register-user-kana" name="user_kana"
                        :value="old('register') == '1' ? old('user_kana') : ''" required autofocus autocomplete="user_kana" placeholder="いーしーたろう" />
                    @if (old('register') == '1')
                        <x-input-error :messages="$errors->get('user_kana')" class="mt-2" />
                    @endif
                </div>
                {{-- メールアドレス --}}
                <div>
                    <x-input-label for="register-email" :value="__('Email')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="register-email" name="email"
                        :value="old('register') == '1' ? old('email') : ''" required autofocus autocomplete="email" placeholder="ec-taro@example.local" />
                    @if (old('register') == '1')
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    @endif
                </div>
                {{-- パスワード --}}
                <div>
                    <x-input-label for="register-password" :value="__('Password')" />
                    <x-text-input class="block mt-1 w-full" type="password" id="register-password" name="password" required
                        autocomplete="new-password" placeholder="ABCabc0123!@#$%^&*" />
                    @if (old('register') == '1')
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    @endif
                </div>
                {{-- パスワード再入力 --}}
                <div>
                    <x-input-label for="register-password-confirm" :value="__('Confirm Password')" />
                    <x-text-input class="block mt-1 w-full" type="password" id="register-password-confirm"
                        name="password_confirmation" required autocomplete="new-password"
                        placeholder="ABCabc0123!@#$%^&*" />
                    @if (old('register') == '1')
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    @endif
                </div>
                <div class="py-4 flex flex-row justify-between gap-2">
                    <div class="my-auto flex flex-row basis-1/6">
                        <x-text-input class="w-8 h-8" type="checkbox" id="register-enable" name="enable_flg" autofocus />
                        <x-input-label class="my-auto pl-2 flex" for="register-enable" :value="__('有効')" />
                    </div>
                    <div class="my-auto flex flex-row basis-1/6">
                        <x-text-input class="w-8 h-8" type="checkbox" id="register-admin" name="admin_flg" autofocus />
                        <x-input-label class="my-auto pl-2 flex" for="register-admin" :value="__('管理者')" />
                    </div>
                    <div class="my-auto flex flex-row basis-2/6">
                        <x-secondary-button class="flex basis-full" type='reset' name="reset" :value="1">
                            <span class="flex m-auto text-xl text-center font-bold">{{ __('リセット') }}</span>
                        </x-secondary-button>
                    </div>
                    <div class="my-auto flex flex-row basis-2/6">
                        <x-primary-button class="flex basis-full" form="register" name="register" :value="1">
                            <span class="flex m-auto text-xl text-center font-bold">{{ __('Register') }}</span>
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
        <div class="container w-full pt-1">
            {{ $ec_users->render() }}
        </div>
        <div class="container">
            @php
                $array = [];
            @endphp
            @foreach ($ec_users as $ec_user)
                @php
                    array_push($array, $ec_user->id);
                @endphp
                <div
                    class="w-full p-4 flex flex-row basis-full gap-2 {{ $loop->first ? 'border-t-2' : '' }} border-b-2 border-sky-50 {{ $ec_user->enable_flg ? ($ec_user->admin_flg ? 'bg-sky-300 dark:bg-sky-800' : 'bg-sky-400 dark:bg-sky-700') : 'bg-sky-200 dark:bg-sky-900' }}">
                    <form class="flex flex-row basis-full gap-2" id="update-{{ $ec_user->id }}"
                        action="{{ url('ec_site/users/update', null, $is_production) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $ec_user->id }}" />
                        <input type="hidden" name="enable_flg" value="{{ $ec_user->enable_flg }}" />
                        <input type="hidden" name="admin_flg" value="{{ $ec_user->admin_flg }}" />
                        <div class="flex flex-col basis-4/5 gap-1">
                            <div class="block">
                                <x-input-label for="update-user-id-{{ $ec_user->id }}" :value="__('ID')" />
                                <x-text-input class="block mt-1 w-full" type="text"
                                    id="update-user-id-{{ $ec_user->id }}" name="user_id" :value="$ec_user->user_id" required
                                    :readonly="$ec_user->user_id == env('DEFAULT_ADMIN_ID', 'ec_admin') || $ec_user->user_id == Auth::user()->user_id" autofocus autocomplete="user_id" placeholder="EcTaro" />
                                @if (old('update') == $ec_user->id)
                                    <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                                @endif
                            </div>
                            <div class="block">
                                <x-input-label for="update-user-name-{{ $ec_user->id }}" :value="__('氏名（漢字）')" />
                                <x-text-input class="block mt-1 w-full" type="text"
                                    id="update-user-name-{{ $ec_user->id }}" name="user_name" :value="$ec_user->user_name"
                                    required autofocus autocomplete="user_name" placeholder="イーシー太郎" />
                                @if (old('update') == $ec_user->id)
                                    <x-input-error :messages="$errors->get('user_name')" class="mt-2" />
                                @endif
                            </div>
                            <div class="block">
                                <x-input-label for="update-user-kana-{{ $ec_user->id }}" :value="__('氏名（かな）')" />
                                <x-text-input class="block mt-1 w-full" type="text"
                                    id="update-user-kana-{{ $ec_user->id }}" name="user_kana" :value="$ec_user->user_kana"
                                    required autofocus autocomplete="user_kana" placeholder="いーしーたろう" />
                                @if (old('update') == $ec_user->id)
                                    <x-input-error :messages="$errors->get('user_kana')" class="mt-2" />
                                @endif
                            </div>
                            <div class="block">
                                <x-input-label for="update-email-{{ $ec_user->id }}" :value="__('Email')" />
                                <x-text-input class="block mt-1 w-full" type="text"
                                    id="update-email-{{ $ec_user->id }}" name="email" :value="$ec_user->email" required
                                    autofocus autocomplete="email" placeholder="ec-taro@example.local" />
                                @if (old('update') == $ec_user->id)
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                @endif
                            </div>
                            <div class="block">
                                <x-input-label for="update-password-{{ $ec_user->id }}" :value="__('Password')" />
                                <x-text-input class="block mt-1 w-full" type="password"
                                    id="update-password-{{ $ec_user->id }}" name="password"
                                    placeholder="ABCabc0123!@#$%^&*" />
                                @if (old('update') == $ec_user->id)
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                @endif
                            </div>
                            <div class="block">
                                <x-input-label for="update-password-confirm-{{ $ec_user->id }}" :value="__('Confirm Password')" />
                                <x-text-input class="block mt-1 w-full" type="password"
                                    id="update-password-confirm-{{ $ec_user->id }}" name="password_confirmation"
                                    placeholder="ABCabc0123!@#$%^&*" />
                                @if (old('update') == $ec_user->id)
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col-reverse basis-1/5 gap-2">
                            <div class="flex basis-full">
                                <x-primary-button class="w-full" form="update-{{ $ec_user->id }}" name="update"
                                    :value="$ec_user->id">
                                    <span class="flex m-auto text-xl text-center font-bold">{{ __('更新') }}</span>
                                </x-primary-button>
                            </div>
                            <div class="flex basis-full">
                                <x-secondary-button class="w-full" type="reset" name="reset">
                                    <span class="flex m-auto text-xl text-center font-bold">{{ __('リセット') }}</span>
                                </x-secondary-button>
                            </div>
                            <div class="flex basis-full">
                                @if (Auth::user()->user_id == env('DEFAULT_ADMIN_ID', 'ec_admin') && $ec_user->user_id != Auth::user()->user_id)
                                    <x-secondary-button class="w-full" type="submit" name="admin" :value="$ec_user->id">
                                        <span
                                            class="flex m-auto text-xl text-center font-bold">{{ __($ec_user->admin_flg ? '一般' : '管理者') }}</span>
                                    </x-secondary-button>
                                @endif
                            </div>
                            <div class="flex basis-full">
                                @if ($ec_user->user_id != env('DEFAULT_ADMIN_ID', 'ec_admin') && $ec_user->user_id != Auth::user()->user_id)
                                    <x-secondary-button class="w-full" type="submit" name="enable" :value="$ec_user->id">
                                        <span
                                            class="flex m-auto text-xl text-center font-bold">{{ __($ec_user->enable_flg ? '無効' : '有効') }}</span>
                                    </x-secondary-button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
        <div class="container w-full">
            {{ $ec_users->render() }}
        </div>
    </div>
@endsection

@section('script')

@endsection
