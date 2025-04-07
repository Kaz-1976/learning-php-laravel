@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', 'ユーザー管理')

{{-- ページメニュー --}}
@section('menu')
    <x-link-button-box>
        <x-link-button class="basis-full" link-type="link" link-to="{{ url('admin', null, app()->isProduction()) }}">
            管理メニュー
        </x-link-button>
    </x-link-button-box>
@endsection

{{-- ページコンテンツ --}}
@section('content')
    <div class="flex flex-col gap-2">
        <form id="register" action="{{ url('admin/users/store', null, app()->isProduction()) }}" method="POST">
            {{-- CRSF対策 --}}
            @csrf
            {{-- 登録カード --}}
            <x-register-card>
                <x-card-box :direction="'col'">
                    {{-- ユーザーID --}}
                    <x-card-item>
                        <x-input-label for="register-user-id" :value="__('ID')" />
                        <x-text-input class="mt-1 block w-full" id="register-user-id" name="user_id" type="text"
                            :value="old('register') == '1' ? old('user_id') : ''" required autofocus autocomplete="user_id" placeholder="EcTaro" />
                        @if (old('register') == '1')
                            <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                        @endif
                    </x-card-item>
                    {{-- 氏名（漢字） --}}
                    <x-card-item>
                        <x-input-label for="register-user-name" :value="__('氏名（漢字）')" />
                        <x-text-input class="mt-1 block w-full" id="register-user-name" name="user_name" type="text"
                            :value="old('register') == '1' ? old('user_name') : ''" required autofocus autocomplete="user_name" placeholder="イーシー太郎" />
                        @if (old('register') == '1')
                            <x-input-error class="mt-2" :messages="$errors->get('user_name')" />
                        @endif
                    </x-card-item>
                    {{-- 氏名（かな） --}}
                    <x-card-item>
                        <x-input-label for="register-user-kana" :value="__('氏名（かな）')" />
                        <x-text-input class="mt-1 block w-full" id="register-user-kana" name="user_kana" type="text"
                            :value="old('register') == '1' ? old('user_kana') : ''" required autofocus autocomplete="user_kana" placeholder="いーしーたろう" />
                        @if (old('register') == '1')
                            <x-input-error class="mt-2" :messages="$errors->get('user_kana')" />
                        @endif
                    </x-card-item>
                    {{-- メールアドレス --}}
                    <x-card-item>
                        <x-input-label for="register-email" :value="__('Email')" />
                        <x-text-input class="mt-1 block w-full" id="register-email" name="email" type="text"
                            :value="old('register') == '1' ? old('email') : ''" required autofocus autocomplete="email"
                            placeholder="ec-taro@example.local" />
                        @if (old('register') == '1')
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        @endif
                    </x-card-item>
                    {{-- パスワード --}}
                    <x-card-item>
                        <x-input-label for="register-password" :value="__('Password')" />
                        <x-text-input class="mt-1 block w-full" id="register-password" name="password" type="password"
                            required autocomplete="new-password" placeholder="ABCabc0123!@#$%^&*_" />
                        @if (old('register') == '1')
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        @endif
                    </x-card-item>
                    {{-- パスワード再入力 --}}
                    <x-card-item>
                        <x-input-label for="register-password-confirm" :value="__('Confirm Password')" />
                        <x-text-input class="mt-1 block w-full" id="register-password-confirm" name="password_confirmation"
                            type="password" required autocomplete="new-password" placeholder="ABCabc0123!@#$%^&*_" />
                        @if (old('register') == '1')
                            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                        @endif
                    </x-card-item>
                </x-card-box>
                {{-- ボタン --}}
                <x-card-box class="justify-between" :direction="'col'" :responsive="true">
                    {{-- チェック --}}
                    <x-card-box class="h-12 md:h-auto md:basis-1/3" :direction="'row'">
                        <div class="my-auto flex basis-1/2 flex-row">
                            <x-text-input class="h-8 w-8" id="register-enable" name="enable_flg" type="checkbox"
                                autofocus />
                            <x-input-label class="my-auto flex pl-2" for="register-enable" :value="__('有効')" />
                        </div>
                        <div class="my-auto flex basis-1/2 flex-row">
                            <x-text-input class="h-8 w-8" id="register-admin" name="admin_flg" type="checkbox" autofocus />
                            <x-input-label class="my-auto flex pl-2" for="register-admin" :value="__('管理者')" />
                        </div>
                    </x-card-box>
                    {{-- ボタン --}}
                    <x-card-box class="h-12 md:h-auto md:basis-2/3" :direction="'row'">
                        <div class="my-auto flex basis-1/2 flex-row">
                            <x-secondary-button class="flex basis-full" name="reset" type='reset' :value="1">
                                <span
                                    class="m-auto flex text-center text-base font-bold md:text-xl">{{ __('リセット') }}</span>
                            </x-secondary-button>
                        </div>
                        <div class="my-auto flex basis-1/2 flex-row">
                            <x-primary-button class="flex basis-full" name="register" form="register" :value="1">
                                <span
                                    class="m-auto flex text-center text-base font-bold md:text-xl">{{ __('Register') }}</span>
                            </x-primary-button>
                        </div>
                    </x-card-box>
                </x-card-box>
            </x-register-card>
        </form>
        @if ($ecUsers->isEmpty())
            <x-empty-string-box>ユーザーが登録されていません。</x-empty-string-box>
        @else
            <div class="w-full">
                {{ $ecUsers->render() }}
            </div>
            <div class="w-full">
                @foreach ($ecUsers as $ecUser)
                    <form id="update-{{ $ecUser->id }}"
                        action="{{ url('admin/users/update', null, app()->isProduction()) }}" method="POST">
                        {{-- CRSF対策 --}}
                        @csrf
                        {{-- 隠し項目 --}}
                        <input name="id" type="hidden" value="{{ $ecUser->id }}" />
                        <input name="enable_flg" type="hidden" value="{{ $ecUser->enable_flg }}" />
                        <input name="admin_flg" type="hidden" value="{{ $ecUser->admin_flg }}" />
                        {{-- 更新カード --}}
                        <x-update-card :loop="$loop->first" :flag="$ecUser->enable_flg" :type="$ecUser->admin_flg">
                            <x-card-box class="basis-4/5">
                                <x-card-item>
                                    <x-input-label for="update-user-id-{{ $ecUser->id }}" :value="__('ID')" />
                                    <x-text-input class="mt-1 block w-full" id="update-user-id-{{ $ecUser->id }}"
                                        name="user_id" type="text" :value="$ecUser->user_id" required :readonly="$ecUser->user_id == env('DEFAULT_ADMIN_ID', 'ec_admin') ||
                                            $ecUser->user_id == Auth::user()->user_id"
                                        autofocus autocomplete="user_id" placeholder="EcTaro" />
                                    @if (old('update') == $ecUser->id)
                                        <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                                    @endif
                                </x-card-item>
                                <x-card-item>
                                    <x-input-label for="update-user-name-{{ $ecUser->id }}" :value="__('氏名（漢字）')" />
                                    <x-text-input class="mt-1 block w-full" id="update-user-name-{{ $ecUser->id }}"
                                        name="user_name" type="text" :value="$ecUser->user_name" required autofocus
                                        autocomplete="user_name" placeholder="イーシー太郎" />
                                    @if (old('update') == $ecUser->id)
                                        <x-input-error class="mt-2" :messages="$errors->get('user_name')" />
                                    @endif
                                </x-card-item>
                                <x-card-item>
                                    <x-input-label for="update-user-kana-{{ $ecUser->id }}" :value="__('氏名（かな）')" />
                                    <x-text-input class="mt-1 block w-full" id="update-user-kana-{{ $ecUser->id }}"
                                        name="user_kana" type="text" :value="$ecUser->user_kana" required autofocus
                                        autocomplete="user_kana" placeholder="いーしーたろう" />
                                    @if (old('update') == $ecUser->id)
                                        <x-input-error class="mt-2" :messages="$errors->get('user_kana')" />
                                    @endif
                                </x-card-item>
                                <x-card-item>
                                    <x-input-label for="update-email-{{ $ecUser->id }}" :value="__('Email')" />
                                    <x-text-input class="mt-1 block w-full" id="update-email-{{ $ecUser->id }}"
                                        name="email" type="text" :value="$ecUser->email" required autofocus
                                        autocomplete="email" placeholder="ec-taro@example.local" />
                                    @if (old('update') == $ecUser->id)
                                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                    @endif
                                </x-card-item>
                                <x-card-item>
                                    <x-input-label for="update-password-{{ $ecUser->id }}" :value="__('Password')" />
                                    <x-text-input class="mt-1 block w-full" id="update-password-{{ $ecUser->id }}"
                                        name="password" type="password" placeholder="ABCabc0123!@#$%^&*_" />
                                    @if (old('update') == $ecUser->id)
                                        <x-input-error class="mt-2" :messages="$errors->get('password')" />
                                    @endif
                                </x-card-item>
                                <x-card-item>
                                    <x-input-label for="update-password-confirm-{{ $ecUser->id }}" :value="__('Confirm Password')" />
                                    <x-text-input class="mt-1 block w-full"
                                        id="update-password-confirm-{{ $ecUser->id }}" name="password_confirmation"
                                        type="password" placeholder="ABCabc0123!@#$%^&*_" />
                                    @if (old('update') == $ecUser->id)
                                        <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                                    @endif
                                </x-card-item>
                            </x-card-box>
                            <x-card-box class="basis-1/5 flex-col-reverse gap-2">
                                <div class="flex h-12 basis-full flex-row-reverse gap-2 md:h-auto md:flex-col-reverse">
                                    <div class="flex h-12 basis-1/2 md:h-auto md:basis-full">
                                        <x-primary-button class="w-full" name="update"
                                            form="update-{{ $ecUser->id }}" :value="$ecUser->id">
                                            <span
                                                class="m-auto flex text-center text-base font-bold md:text-xl">{{ __('更新') }}</span>
                                        </x-primary-button>
                                    </div>
                                    <div class="flex h-12 basis-1/2 md:h-auto md:basis-full">
                                        <x-secondary-button class="w-full" name="reset" type="reset">
                                            <span
                                                class="m-auto flex text-center text-base font-bold md:text-xl">{{ __('リセット') }}</span>
                                        </x-secondary-button>
                                    </div>
                                </div>
                                <div class="flex h-12 basis-full flex-row-reverse gap-2 md:h-auto md:flex-col-reverse">
                                    <div class="flex h-12 basis-1/2 md:h-auto md:basis-full">
                                        @if (Auth::user()->user_id == env('DEFAULT_ADMIN_ID', 'ec_admin') && $ecUser->user_id != Auth::user()->user_id)
                                            <x-secondary-button class="w-full" name="admin" type="submit"
                                                :value="$ecUser->id">
                                                <span
                                                    class="m-auto flex text-center text-base font-bold md:text-xl">{{ __($ecUser->admin_flg ? '一般' : '管理者') }}</span>
                                            </x-secondary-button>
                                        @endif
                                    </div>
                                    <div class="flex h-12 basis-1/2 md:h-auto md:basis-full">
                                        @if ($ecUser->user_id != env('DEFAULT_ADMIN_ID', 'ec_admin') && $ecUser->user_id != Auth::user()->user_id)
                                            <x-secondary-button class="w-full" name="enable" type="submit"
                                                :value="$ecUser->id">
                                                <span
                                                    class="m-auto flex text-center text-base font-bold md:text-xl">{{ __($ecUser->enable_flg ? '無効' : '有効') }}</span>
                                            </x-secondary-button>
                                        @endif
                                    </div>
                                </div>
                            </x-card-box>
                        </x-update-card>
                    </form>
                @endforeach
            </div>
            <div class="w-full">
                {{ $ecUsers->render() }}
            </div>
        @endif
    </div>
@endsection

@section('script')

@endsection
