@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '配送先設定')

{{-- ページメニュー --}}
@section('menu')
    <x-link-button-box>
        <x-link-button class="basis-full" link-type="link" link-to="{{ url('cart', null, app()->isProduction()) }}">
            カートに戻る
        </x-link-button>
    </x-link-button-box>
@endsection

{{-- ページコンテンツ --}}
@section('content')
    <div class="flex flex-col gap-4">
        <form class="flex flex-col gap-4 rounded-lg border-2 border-solid border-sky-950 p-4 dark:border-sky-50"
            id="select" action="{{ url('shipping/store', null, app()->isProduction()) }}" method="POST">
            @csrf
            {{-- 配送先名 --}}
            <div class="flex basis-full flex-col gap-2 md:flex-row">
                <div class="flex flex-col justify-stretch md:basis-1/2">
                    <select class="" id="id" name="id" required>
                        <option value="" selected>
                            配送先選択
                        </option>
                        <option value="0">
                            新規配送先
                        </option>
                        @foreach ($ecAddresses as $ecAddress)
                            <option value="{{ $ecAddress->id }}">
                                {{ $ecAddress->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="my-auto flex flex-row md:basis-1/2">
                    <x-primary-button class="flex basis-full" name="select" form="select" :value="0">
                        <span class="m-auto flex text-center text-base font-bold md:text-xl">{{ __('決定') }}</span>
                    </x-primary-button>
                </div>
            </div>
            {{-- 配送先名 --}}
            <div class="hidden basis-full flex-row gap-2">
                <div class="flex basis-full flex-col justify-stretch">
                    <x-input-label for="register-name" :value="__('配送先名')" />
                    <x-text-input class="mt-1 flex w-full" id="register-name" name="name" type="text"
                        :value="old('name')" autofocus autocomplete="name" placeholder="" />
                    @if (old('register') == 0)
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    @endif
                </div>
            </div>
            <div class="flex basis-full flex-col gap-2 md:flex-row">
                {{-- 郵便番号 --}}
                <div class="flex basis-1/2 flex-col justify-stretch gap-1 md:flex-row">
                    <div class="flex basis-full flex-col justify-stretch">
                        <x-input-label for="zip" :value="__('郵便番号')" />
                        <x-text-input class="mt-1 block" id="zip" name="zip" type="text" :value="''"
                            :disabled="true" />
                        <x-input-error class="mt-2" :messages="$errors->get('zip')" />
                    </div>
                    <div class="hidden basis-1/2 flex-col justify-stretch">
                        <x-secondary-button class="h-full w-full basis-full" name="search">
                            <span class="md:text-md m-auto flex text-center text-sm font-bold">{{ __('住所検索') }}</span>
                        </x-secondary-button>
                    </div>
                </div>
                {{-- 都道府県 --}}
                <div class="flex basis-1/2 flex-col justify-stretch">
                    <x-input-label for="pref" :value="__('都道府県')" />
                    <x-text-input class="mt-1 block w-full" id="pref" name="pref" type="text" :value="''"
                        :disabled="true" />
                    <select class="hidden" id="pref" name="pref" data-default="" required>
                        <option value="" selected>都道府県選択</option>
                        @foreach ($prefs as $pref)
                            <option value="{{ $pref['code'] }}">{{ $pref['name'] }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('pref')" />
                </div>
            </div>
            {{-- 住所１ --}}
            <div class="flex basis-full flex-row gap-2">
                <div class="flex basis-full flex-col justify-stretch">
                    <x-input-label for="address1" :value="__('住所１')" />
                    <x-text-input class="mt-1 flex w-full" id="address1" name="address1" type="text" :value="''"
                        :disabled="true" />
                    <x-input-error class="mt-2" :messages="$errors->get('address1')" />
                </div>
            </div>
            {{-- 住所２ --}}
            <div class="flex basis-full flex-row gap-2">
                <div class="flex basis-full flex-col justify-stretch">
                    <x-input-label for="address2" :value="__('住所２')" />
                    <x-text-input class="mt-1 flex w-full" id="address2" name="address2" type="text" :value="''"
                        :disabled="true" />
                    <x-input-error class="mt-2" :messages="$errors->get('address2')" />
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        // ------------------------------------------------------------
        // 画面ロード時実行関数
        // ------------------------------------------------------------
        window.addEventListener('DOMContentLoaded', () => {
            // 配送先選択時の処理
            const selects = document.querySelectorAll('select[name="id"]');
            selects.forEach((select) => {
                select.addEventListener('change', (event) => {
                    common.setShippingForm(event);
                    common.getAddressInfo(event, {{ Auth::user()->id }});
                });
            });
            // 住所検索ボタン押下時の処理
            const buttons = document.querySelectorAll('button[name="search"]');
            buttons.forEach((button) => {
                button.addEventListener('click', (event) => {
                    // 住所検索処理
                    common.getZipInfo(event);
                });
            });
        }, false);
    </script>
@endsection
