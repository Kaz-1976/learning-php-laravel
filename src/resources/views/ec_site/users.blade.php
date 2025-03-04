@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', 'ユーザー管理')

{{-- ページコンテンツ --}}
@section('content')
    <div class="flex flex-col gap-4">
        <form class="flex flex-col gap-1 p-4 border-solid border-2 rounded-lg border-sky-950 dark:border-sky-50"
            id="register" action="{{ url('/admin/users/store', null, app()->isProduction()) }}" method="POST">
            @csrf
            {{-- ユーザーID --}}
            <div>
                <x-input-label for="register-user-id" :value="__('ID')" />
                <x-text-input class="block mt-1 w-full" type="text" id="register-user-id" name="user_id" :value="old('register') == '1' ? old('user_id') : ''"
                    required autofocus autocomplete="user_id" placeholder="EcTaro" />
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
                <x-text-input class="block mt-1 w-full" type="text" id="register-email" name="email" :value="old('register') == '1' ? old('email') : ''"
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
                <div class="flex flex-row md:basis-1/3 gap-2 h-12 md:h-auto">
                    <div class="flex flex-row basis-1/2 my-auto">
                        <x-text-input class="w-8 h-8" type="checkbox" id="register-enable" name="enable_flg" autofocus />
                        <x-input-label class="my-auto pl-2 flex" for="register-enable" :value="__('有効')" />
                    </div>
                    <div class="flex flex-row basis-1/2 my-auto">
                        <x-text-input class="w-8 h-8" type="checkbox" id="register-admin" name="admin_flg" autofocus />
                        <x-input-label class="my-auto pl-2 flex" for="register-admin" :value="__('管理者')" />
                    </div>
                </div>
                <div class="flex flex-row md:basis-2/3 gap-2 h-12 md:h-auto">
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
        @if ($ecUsers->isEmpty())
            <div class="flex flex-row flex-wrap py-2 border-t-2 border-b-2 border-sky-950 dark:border-sky-50">
                <x-empty-string-box>ユーザーが登録されていません。</x-empty-string-box>
            </div>
        @else
            <div class="w-full">
                {{ $ecUsers->render() }}
            </div>
            <div class="w-full">
                @php
                    $array = [];
                @endphp
                @foreach ($ecUsers as $ecUser)
                    @php
                        array_push($array, $ecUser->id);
                    @endphp
                    <form
                        class="flex flex-col md:flex-row basis-full gap-4 w-full p-4 {{ $loop->first ? 'border-t-2' : '' }} border-b-2 border-sky-50 {{ $ecUser->enable_flg ? ($ecUser->admin_flg ? 'bg-sky-300 dark:bg-sky-800' : 'bg-sky-400 dark:bg-sky-700') : 'bg-sky-200 dark:bg-sky-900' }}"
                        id="update-{{ $ecUser->id }}"
                        action="{{ url('admin/users/update', null, app()->isProduction()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $ecUser->id }}" />
                        <input type="hidden" name="enable_flg" value="{{ $ecUser->enable_flg }}" />
                        <input type="hidden" name="admin_flg" value="{{ $ecUser->admin_flg }}" />
                        <div class="flex flex-col basis-4/5 gap-1">
                            <div class="block">
                                <x-input-label for="update-user-id-{{ $ecUser->id }}" :value="__('ID')" />
                                <x-text-input class="block mt-1 w-full" type="text"
                                    id="update-user-id-{{ $ecUser->id }}" name="user_id" :value="$ecUser->user_id" required
                                    :readonly="$ecUser->user_id == env('DEFAULT_ADMIN_ID', 'ec_admin') ||
                                        $ecUser->user_id == Auth::user()->user_id" autofocus autocomplete="user_id" placeholder="EcTaro" />
                                @if (old('update') == $ecUser->id)
                                    <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                                @endif
                            </div>
                            <div class="block">
                                <x-input-label for="update-user-name-{{ $ecUser->id }}" :value="__('氏名（漢字）')" />
                                <x-text-input class="block mt-1 w-full" type="text"
                                    id="update-user-name-{{ $ecUser->id }}" name="user_name" :value="$ecUser->user_name"
                                    required autofocus autocomplete="user_name" placeholder="イーシー太郎" />
                                @if (old('update') == $ecUser->id)
                                    <x-input-error :messages="$errors->get('user_name')" class="mt-2" />
                                @endif
                            </div>
                            <div class="block">
                                <x-input-label for="update-user-kana-{{ $ecUser->id }}" :value="__('氏名（かな）')" />
                                <x-text-input class="block mt-1 w-full" type="text"
                                    id="update-user-kana-{{ $ecUser->id }}" name="user_kana" :value="$ecUser->user_kana"
                                    required autofocus autocomplete="user_kana" placeholder="いーしーたろう" />
                                @if (old('update') == $ecUser->id)
                                    <x-input-error :messages="$errors->get('user_kana')" class="mt-2" />
                                @endif
                            </div>
                            <div class="block">
                                <x-input-label for="update-email-{{ $ecUser->id }}" :value="__('Email')" />
                                <x-text-input class="block mt-1 w-full" type="text"
                                    id="update-email-{{ $ecUser->id }}" name="email" :value="$ecUser->email" required
                                    autofocus autocomplete="email" placeholder="ec-taro@example.local" />
                                @if (old('update') == $ecUser->id)
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                @endif
                            </div>
                            <div class="block">
                                <x-input-label for="update-password-{{ $ecUser->id }}" :value="__('Password')" />
                                <x-text-input class="block mt-1 w-full" type="password"
                                    id="update-password-{{ $ecUser->id }}" name="password"
                                    placeholder="ABCabc0123!@#$%^&*_" />
                                @if (old('update') == $ecUser->id)
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                @endif
                            </div>
                            <div class="block">
                                <x-input-label for="update-password-confirm-{{ $ecUser->id }}" :value="__('Confirm Password')" />
                                <x-text-input class="block mt-1 w-full" type="password"
                                    id="update-password-confirm-{{ $ecUser->id }}" name="password_confirmation"
                                    placeholder="ABCabc0123!@#$%^&*_" />
                                @if (old('update') == $ecUser->id)
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col-reverse basis-1/5 gap-2">
                            <div class="flex flex-row-reverse md:flex-col-reverse gap-2 basis-full h-12 md:h-auto">
                                <div class="flex basis-1/2 md:basis-full h-12 md:h-auto">
                                    <x-primary-button class="w-full" form="update-{{ $ecUser->id }}" name="update"
                                        :value="$ecUser->id">
                                        <span
                                            class="flex m-auto text-base md:text-xl text-center font-bold">{{ __('更新') }}</span>
                                    </x-primary-button>
                                </div>
                                <div class="flex basis-1/2 md:basis-full h-12 md:h-auto">
                                    <x-secondary-button class="w-full" type="reset" name="reset">
                                        <span
                                            class="flex m-auto text-base md:text-xl text-center font-bold">{{ __('リセット') }}</span>
                                    </x-secondary-button>
                                </div>
                            </div>
                            <div class="flex flex-row-reverse md:flex-col-reverse gap-2 basis-full h-12 md:h-auto">
                                <div class="flex basis-1/2 md:basis-full h-12 md:h-auto">
                                    @if (Auth::user()->user_id == env('DEFAULT_ADMIN_ID', 'ec_admin') && $ecUser->user_id != Auth::user()->user_id)
                                        <x-secondary-button class="w-full" type="submit" name="admin"
                                            :value="$ecUser->id">
                                            <span
                                                class="flex m-auto text-base md:text-xl text-center font-bold">{{ __($ecUser->admin_flg ? '一般' : '管理者') }}</span>
                                        </x-secondary-button>
                                    @endif
                                </div>
                                <div class="flex basis-1/2 md:basis-full h-12 md:h-auto">
                                    @if ($ecUser->user_id != env('DEFAULT_ADMIN_ID', 'ec_admin') && $ecUser->user_id != Auth::user()->user_id)
                                        <x-secondary-button class="w-full" type="submit" name="enable"
                                            :value="$ecUser->id">
                                            <span
                                                class="flex m-auto text-base md:text-xl text-center font-bold">{{ __($ecUser->enable_flg ? '無効' : '有効') }}</span>
                                        </x-secondary-button>
                                    @endif
                                </div>
                            </div>
                        </div>
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
