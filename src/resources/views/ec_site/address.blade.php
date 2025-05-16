@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '配送先管理')

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
    {{-- 本体 --}}
    <div class="flex flex-col gap-2">
        <form id="register" action="{{ url('/mypage/address/store', null, app()->isProduction()) }}" method="POST">
            {{-- CSRF対策 --}}
            @csrf
            {{-- 隠し項目 --}}
            <input name="id" type="hidden" value="0" />
            <x-register-card>
                {{-- 宛先名 --}}
                <div class="flex basis-full flex-row gap-2">
                    <div class="flex basis-full flex-col justify-stretch">
                        <x-input-label for="register-name" :value="__('宛先名')" />
                        <x-text-input class="mt-1 flex w-full" id="register-name" name="name" type="text"
                            :value="old('name')" autofocus autocomplete="name" placeholder="" />
                        @if (old('register') == 0)
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        @endif
                    </div>
                </div>
                {{-- 郵便番号 --}}
                <div class="flex basis-full flex-row gap-2">
                    <div class="flex basis-1/2 flex-col justify-stretch">
                        <x-input-label for="register-zip" :value="__('郵便番号')" />
                        <x-text-input class="mt-1 block w-full" id="register-zip" name="zip" type="text"
                            :value="old('zip')" required autofocus autocomplete="zip" placeholder="1234567" />
                        @if (old('register') == 0)
                            <x-input-error class="mt-2" :messages="$errors->get('zip')" />
                        @endif
                    </div>
                    <div class="flex basis-1/2 justify-stretch">
                        <x-secondary-button class="h-full w-full" id="register-get-address" name="search">
                            <span class="m-auto flex text-center text-base font-bold md:text-xl">{{ __('住所検索') }}</span>
                        </x-secondary-button>
                    </div>
                </div>
                {{-- 都道府県 --}}
                <div class="flex basis-full flex-col justify-stretch gap-2">
                    <x-input-label for="register-pref" :value="__('都道府県')" />
                    <select class="" id="register-pref" name="pref" data-default="" required>
                        <option value="" selected>都道府県を選択してください</option>
                        @foreach ($prefs as $pref)
                            <option value="{{ $pref['code'] }}">{{ $pref['name'] }}</option>
                        @endforeach
                    </select>
                    @if (old('register') == 0)
                        <x-input-error class="mt-2" :messages="$errors->get('pref')" />
                    @endif
                </div>
                {{-- 住所１ --}}
                <div class="flex basis-full flex-row gap-2">
                    <div class="flex basis-full flex-col justify-stretch">
                        <x-input-label for="register-address1" :value="__('住所１')" />
                        <x-text-input class="mt-1 flex w-full" id="register-address1" name="address1" type="text"
                            :value="old('address1')" required autofocus autocomplete="address1" placeholder="" />
                        @if (old('register') == 0)
                            <x-input-error class="mt-2" :messages="$errors->get('address1')" />
                        @endif
                    </div>
                </div>
                {{-- 住所２ --}}
                <div class="flex basis-full flex-row gap-2">
                    <div class="flex basis-full flex-col justify-stretch">
                        <x-input-label for="register-address2" :value="__('住所２')" />
                        <x-text-input class="mt-1 flex w-full" id="register-address2" name="address2" type="text"
                            :value="old('address2')" autofocus autocomplete="address2" placeholder="" />
                        @if (old('register') == 0)
                            <x-input-error class="mt-2" :messages="$errors->get('address2')" />
                        @endif
                    </div>
                </div>
                <div class="flex flex-row-reverse justify-between gap-2">
                    <div class="my-auto flex basis-1/2 flex-row">
                        <x-primary-button class="flex basis-full" name="register" form="register" :value="0">
                            <span class="m-auto flex text-center text-base font-bold md:text-xl">{{ __('Register') }}</span>
                        </x-primary-button>
                    </div>
                    <div class="my-auto flex basis-1/2 flex-row">
                        <x-secondary-button class="flex basis-full" name="reset" type='reset' :value="0">
                            <span class="m-auto flex text-center text-base font-bold md:text-xl">{{ __('リセット') }}</span>
                        </x-secondary-button>
                    </div>
                </div>
            </x-register-card>
        </form>
        <div class="w-full">
            {{ $ecAddresses->render() }}
        </div>
        <div class="w-full">
            <div class="flex flex-col">
                @foreach ($ecAddresses as $ecAddress)
                    <form id="update-{{ $ecAddress->id }}"
                        action="{{ url('mypage/address/update', null, app()->isProduction()) }}" method="POST">
                        {{-- CSRF対策 --}}
                        @csrf
                        {{-- 隠し項目 --}}
                        <input name="id" type="hidden" value="{{ $ecAddress->id }}" />
                        {{-- 入力項目 --}}
                        <x-update-card loop="{{ $loop->first }}">
                            <div class="flex basis-4/5 flex-col gap-2">
                                {{-- 宛先名 --}}
                                <div class="flex basis-full flex-row gap-2">
                                    <div class="flex basis-full flex-col justify-stretch">
                                        <x-input-label for="update-{{ $ecAddress->id }}-address2" :value="__('配送先名')" />
                                        <x-text-input class="mt-1 flex w-full" id="update-{{ $ecAddress->id }}-name"
                                            name="name" type="text" :value="$ecAddress->name" required autofocus
                                            autocomplete="name" placeholder="" />
                                        @if (old('update') == $ecAddress->id)
                                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                        @endif
                                    </div>
                                </div>
                                <div class="flex basis-1/2 flex-row gap-2">
                                    {{-- 郵便番号 --}}
                                    <div class="flex basis-3/4 flex-col">
                                        <x-input-label for="update-{{ $ecAddress->id }}-zip" :value="__('郵便番号')" />
                                        <x-text-input class="mt-1 block w-full" id="update-{{ $ecAddress->id }}-zip"
                                            name="zip" type="text" :value="$ecAddress->zip" required autofocus
                                            autocomplete="zip" placeholder="1234567" />
                                        @if (old('update') == $ecAddress->id)
                                            <x-input-error class="mt-2" :messages="$errors->get('zip')" />
                                        @endif
                                    </div>
                                    <div class="flex basis-1/2 justify-stretch">
                                        <x-secondary-button class="h-full w-full" name="search" type="submit">
                                            <span
                                                class="m-auto flex text-center text-base font-bold md:text-xl">{{ __('住所検索') }}</span>
                                        </x-secondary-button>
                                    </div>
                                </div>
                                {{-- 都道府県 --}}
                                <div class="flex basis-full flex-col justify-stretch gap-2">
                                    <x-input-label for="update-pref-{{ $ecAddress->id }}" :value="__('都道府県')" />
                                    <select id="update-{{ $ecAddress->id }}-pref" name="pref"
                                        data-default="{{ $ecAddress->pref }}" required>
                                        <option value="">都道府県を選択してください</option>
                                        @foreach ($prefs as $pref)
                                            <option value="{{ $pref['code'] }}"
                                                {{ $pref['code'] === $ecAddress->pref ? 'selected' : '' }}>
                                                {{ $pref['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- 住所１ --}}
                                <div class="flex basis-full flex-row gap-2">
                                    <div class="flex basis-full flex-col justify-stretch">
                                        <x-input-label for="update-{{ $ecAddress->id }}-address1" :value="__('住所１')" />
                                        <x-text-input class="mt-1 flex w-full" id="update-{{ $ecAddress->id }}-address1"
                                            name="address1" type="text" :value="$ecAddress->address1" required autofocus
                                            autocomplete="address1" placeholder="" />
                                        @if (old('update') == $ecAddress->id)
                                            <x-input-error class="mt-2" :messages="$errors->get('address1')" />
                                        @endif
                                    </div>
                                </div>
                                {{-- 住所２ --}}
                                <div class="flex basis-full flex-row gap-2">
                                    <div class="flex basis-full flex-col justify-stretch">
                                        <x-input-label for="update-{{ $ecAddress->id }}-address2" :value="__('住所２')" />
                                        <x-text-input class="mt-1 flex w-full" id="update-{{ $ecAddress->id }}-address2"
                                            name="address2" type="text" :value="$ecAddress->address2" autofocus
                                            autocomplete="address2" placeholder="" />
                                        @if (old('update') == $ecAddress->id)
                                            <x-input-error class="mt-2" :messages="$errors->get('address2')" />
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- ボタン --}}
                            <div class="flex basis-1/5 flex-col-reverse gap-2">
                                <div class="flex h-12 basis-full flex-row-reverse gap-2 md:h-auto md:flex-col-reverse">
                                    <div class="flex h-12 basis-1/3 md:h-auto md:basis-full">
                                        <x-primary-button class="w-full" name="update"
                                            form="update-{{ $ecAddress->id }}" :value="$ecAddress->id">
                                            <span
                                                class="m-auto flex text-center text-base font-bold md:text-xl">{{ __('更新') }}</span>
                                        </x-primary-button>
                                    </div>
                                    <div class="flex h-12 basis-1/3 md:h-auto md:basis-full">
                                        <x-secondary-button class="w-full" name="delete"
                                            formaction="{{ url('mypage/address/destroy', null, app()->isProduction()) }}"
                                            formmethod="POST" type="submit" value="{{ $ecAddress->id }}">
                                            <span
                                                class="m-auto flex text-center text-base font-bold md:text-xl">{{ __('削除') }}</span>
                                        </x-secondary-button>
                                    </div>
                                    <div class="flex h-12 basis-1/3 md:h-auto md:basis-full">
                                        <x-secondary-button class="w-full" name="reset" type="reset">
                                            <span
                                                class="m-auto flex text-center text-base font-bold md:text-xl">{{ __('リセット') }}</span>
                                        </x-secondary-button>
                                    </div>
                                </div>
                            </div>
                        </x-update-card>
                    </form>
                @endforeach
            </div>
        </div>
        <div class="w-full">
            {{ $ecAddresses->render() }}
        </div>
    </div>
@endsection

@section('script')
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            // 住所検索ボタン
            const buttons = document.querySelectorAll('button[name="search"]');
            // 住所検索ボタンクリック時の処理
            buttons.forEach((button) => {
                button.addEventListener('click', (event) => {
                    // 住所検索処理
                    common.getZipInfo(event);
                });
            });
            // フォームリセットボタン
            Array.prototype.forEach.call(document.forms, (form) => {
                // フォームリセット時の処理
                form.addEventListener('reset', (event) => {
                    // 都道府県リストボックス初期化
                    common.initListBox(event);
                });
            });
        });
    </script>
@endsection
