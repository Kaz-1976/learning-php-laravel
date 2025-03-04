@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '宛先管理')

{{-- ページコンテンツ --}}
@section('content')
    {{-- PHP --}}
    @php
        // セッションから値を取得
        $form = session('form');
        $search = session('search');

        // 値をセット
        function getValue($formData, $key, $default = '')
        {
            if (empty($formData)) {
                // フォームデータが空ならデフォルト値を返す
                return $default;
            } else {
                // フォームデータからキーに対応する値を返す
                return $formData[$key];
            }
        }
        // 選択状態を取得
        function getSelect($data, $key, $value)
        {
            return $data[$key] == $value ? 'selected' : '';
        }
    @endphp
    <div class="flex flex-col gap-4">
        <form class="flex flex-col gap-4 p-4 border-solid border-2 rounded-lg border-sky-950 dark:border-sky-50"
            id="register" action="{{ url('/mypage/address/store', null, app()->isProduction()) }}" method="POST">
            @csrf
            {{-- 隠し項目 --}}
            <input type="hidden" name="id" value="0" />
            {{-- 宛先名 --}}
            <div class="flex flex-row basis-full gap-2">
                <div class="flex flex-col basis-full justify-stretch">
                    <x-input-label for="register-address2" :value="__('宛先名')" />
                    <x-text-input class="flex mt-1 w-full" type="text" id="register-name" name="name"
                        :value="old('name')" autofocus autocomplete="name" placeholder="" />
                    @if (old('register') == 0)
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    @endif
                </div>
            </div>
            {{-- 郵便番号 --}}
            <div class="flex flex-row basis-full gap-2">
                <div class="flex flex-col basis-1/2 justify-stretch">
                    <x-input-label for="register-zip" :value="__('郵便番号')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="register-zip" name="zip"
                        :value="old('zip')" required autofocus autocomplete="zip" placeholder="1234567" />
                    @if (old('register') == 0)
                        <x-input-error :messages="$errors->get('zip')" class="mt-2" />
                    @endif
                </div>
                <div class="flex basis-1/2 justify-stretch">
                    <x-secondary-button class="w-full h-full" id="register-get-address" name="search">
                        <span class="flex m-auto text-base md:text-xl text-center font-bold">{{ __('住所検索') }}</span>
                    </x-secondary-button>
                </div>
            </div>
            {{-- 都道府県 --}}
            <div class="flex flex-col basis-full justify-stretch gap-2">
                <x-input-label for="register-pref" :value="__('都道府県')" />
                <select class="" id="register-pref" name="pref" required>
                    <option value="" selected>都道府県を選択してください</option>
                    @foreach ($prefs as $pref)
                        <option value="{{ $pref['code'] }}">{{ $pref['name'] }}</option>
                    @endforeach
                </select>
                @if (old('register') == 0)
                    <x-input-error :messages="$errors->get('pref')" class="mt-2" />
                @endif
            </div>
            {{-- 住所１ --}}
            <div class="flex flex-row basis-full gap-2">
                <div class="flex flex-col basis-full justify-stretch">
                    <x-input-label for="register-address1" :value="__('住所１')" />
                    <x-text-input class="flex mt-1 w-full" type="text" id="register-address1" name="address1"
                        :value="old('address1')" required autofocus autocomplete="address1" placeholder="" />
                    @if (old('register') == 0)
                        <x-input-error :messages="$errors->get('address1')" class="mt-2" />
                    @endif
                </div>
            </div>
            {{-- 住所２ --}}
            <div class="flex flex-row basis-full gap-2">
                <div class="flex flex-col basis-full justify-stretch">
                    <x-input-label for="register-address2" :value="__('住所２')" />
                    <x-text-input class="flex mt-1 w-full" type="text" id="register-address2" name="address2"
                        :value="old('address2')" autofocus autocomplete="address2" placeholder="" />
                    @if (old('register') == 0)
                        <x-input-error :messages="$errors->get('address2')" class="mt-2" />
                    @endif
                </div>
            </div>
            <div class="flex flex-row-reverse justify-between gap-2">
                <div class="flex flex-row basis-1/2 my-auto">
                    <x-primary-button class="flex basis-full" form="register" name="register" :value="0">
                        <span class="flex m-auto text-base md:text-xl text-center font-bold">{{ __('Register') }}</span>
                    </x-primary-button>
                </div>
                <div class="flex flex-row basis-1/2 my-auto">
                    <x-secondary-button class="flex basis-full" type='reset' name="reset" :value="0">
                        <span class="flex m-auto text-base md:text-xl text-center font-bold">{{ __('リセット') }}</span>
                    </x-secondary-button>
                </div>
            </div>
        </form>
        <div class="w-full">
            {{ $ecAddresses->render() }}
        </div>
        <div class="w-full">
            @foreach ($ecAddresses as $ecAddress)
                <div class="flex flex-col gap-4">
                    <form
                        class="flex flex-col md:flex-row basis-full gap-4 w-full p-4 {{ $loop->first ? 'border-t-2' : '' }} border-b-2 border-sky-50 {{ $ecAddress->enable_flg ? ($ecAddress->admin_flg ? 'bg-sky-300 dark:bg-sky-800' : 'bg-sky-400 dark:bg-sky-700') : 'bg-sky-200 dark:bg-sky-900' }}"
                        id="update-{{ $ecAddress->id }}"
                        action="{{ url('/mypage/address/update', null, app()->isProduction()) }}" method="POST">
                        @csrf
                        {{-- 隠し項目 --}}
                        <input type="hidden" name="id" value="{{ $ecAddress->id }}" />
                        {{-- 入力項目 --}}
                        <div class="flex flex-col basis-4/5 gap-2">
                            {{-- 宛先名 --}}
                            <div class="flex flex-row basis-full gap-2">
                                <div class="flex flex-col basis-full justify-stretch">
                                    <x-input-label for="update-{{ $ecAddress->id }}-address2" :value="__('宛先名')" />
                                    <x-text-input class="flex mt-1 w-full" type="text"
                                        id="update-{{ $ecAddress->id }}-name" name="name" :value="$ecAddress->name" required
                                        autofocus autocomplete="name" placeholder="" />
                                    @if (old('update') == $ecAddress->id)
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-row basis-1/2 gap-2">
                                {{-- 郵便番号 --}}
                                <div class="flex flex-col basis-3/4">
                                    <x-input-label for="update-{{ $ecAddress->id }}-zip" :value="__('郵便番号')" />
                                    <x-text-input class="block mt-1 w-full" type="text"
                                        id="update-{{ $ecAddress->id }}-zip" name="zip" :value="$ecAddress->zip" required
                                        autofocus autocomplete="zip" placeholder="1234567" />
                                    @if (old('update') == $ecAddress->id)
                                        <x-input-error :messages="$errors->get('zip')" class="mt-2" />
                                    @endif
                                </div>
                                <div class="flex basis-1/2 justify-stretch">
                                    <x-secondary-button class="w-full h-full" type="submit" name="search">
                                        <span
                                            class="flex m-auto text-base md:text-xl text-center font-bold">{{ __('住所検索') }}</span>
                                    </x-secondary-button>
                                </div>
                            </div>
                            {{-- 都道府県 --}}
                            <div class="flex flex-col basis-full justify-stretch gap-2">
                                <x-input-label for="update-pref-{{ $ecAddress->id }}" :value="__('都道府県')" />
                                <select id="update-{{ $ecAddress->id }}-pref" name="pref" required>
                                    <option value="">都道府県を選択してください</option>
                                    @foreach ($prefs as $pref)
                                        @php
                                            $selected = getSelect($pref, 'code', $ecAddress->pref);
                                        @endphp
                                        <option value="{{ $pref['code'] }}" {{ $selected }}>
                                            {{ $pref['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- 住所１ --}}
                            <div class="flex flex-row basis-full gap-2">
                                <div class="flex flex-col basis-full justify-stretch">
                                    <x-input-label for="update-{{ $ecAddress->id }}-address1" :value="__('住所１')" />
                                    <x-text-input class="flex mt-1 w-full" type="text"
                                        id="update-{{ $ecAddress->id }}-address1" name="address1" :value="$ecAddress->address1"
                                        required autofocus autocomplete="address1" placeholder="" />
                                    @if (old('update') == $ecAddress->id)
                                        <x-input-error :messages="$errors->get('address1')" class="mt-2" />
                                    @endif
                                </div>
                            </div>
                            {{-- 住所２ --}}
                            <div class="flex flex-row basis-full gap-2">
                                <div class="flex flex-col basis-full justify-stretch">
                                    <x-input-label for="update-{{ $ecAddress->id }}-address2" :value="__('住所２')" />
                                    <x-text-input class="flex mt-1 w-full" type="text"
                                        id="update-{{ $ecAddress->id }}-address2" name="address2" :value="$ecAddress->address2"
                                        autofocus autocomplete="address2" placeholder="" />
                                    @if (old('update') == $ecAddress->id)
                                        <x-input-error :messages="$errors->get('address2')" class="mt-2" />
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- ボタン --}}
                        <div class="flex flex-col-reverse basis-1/5 gap-2">
                            <div class="flex flex-row-reverse md:flex-col-reverse gap-2 basis-full h-12 md:h-auto">
                                <div class="flex basis-1/2 md:basis-full h-12 md:h-auto">
                                    <x-primary-button class="w-full" form="update-{{ $ecAddress->id }}" name="update"
                                        :value="$ecAddress->id">
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
                        </div>
                    </form>
                </div>
            @endforeach
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
                    getAddress(event);
                });
            });
        });
    </script>
@endsection
