@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '配送先設定')

{{-- ページコンテンツ --}}
@section('content')
    <div class="flex flex-col gap-4">
        <form class="flex flex-col gap-4 p-4 border-solid border-2 rounded-lg border-sky-950 dark:border-sky-50"
            id="register" action="{{ url('shipping/store', null, app()->isProduction()) }}" method="POST">
            @csrf
            {{-- 宛先名 --}}
            <div class="flex flex-row basis-full gap-2">
                <div class="flex flex-col basis-1/2 justify-stretch">
                    <select class="" id="id" name="id" required>
                        <option value="" selected>宛先を選択してください</option>
                        @foreach ($ecAddresses as $ecAddress)
                            <option value="{{ $ecAddress->id }}">
                                {{ $ecAddress->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-row basis-1/2 my-auto">
                    <x-primary-button class="flex basis-full" form="register" name="register-select" :value="0">
                        <span class="flex m-auto text-base md:text-xl text-center font-bold">{{ __('決定') }}</span>
                    </x-primary-button>
                </div>
            </div>
            <div class="flex flex-row basis-full gap-2">
                {{-- 郵便番号 --}}
                <div class="flex flex-col basis-1/3 justify-stretch">
                    <x-input-label for="zip" :value="__('郵便番号')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="zip" name="zip" :value="''"
                        :disabled="true" />
                </div>
                {{-- 都道府県 --}}
                <div class="flex flex-col basis-2/3 justify-stretch">
                    <x-input-label for="pref" :value="__('都道府県')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="pref" name="pref" :value="''"
                        :disabled="true" />
                </div>
            </div>
            {{-- 住所１ --}}
            <div class="flex flex-row basis-full gap-2">
                <div class="flex flex-col basis-full justify-stretch">
                    <x-input-label for="address1" :value="__('住所１')" />
                    <x-text-input class="flex mt-1 w-full" type="text" id="address1" name="address1" :value="''"
                        :disabled="true" />
                </div>
            </div>
            {{-- 住所２ --}}
            <div class="flex flex-row basis-full gap-2">
                <div class="flex flex-col basis-full justify-stretch">
                    <x-input-label for="address2" :value="__('住所２')" />
                    <x-text-input class="flex mt-1 w-full" type="text" id="address2" name="address2" :value="''"
                        :disabled="true" />
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
            // 画像選択時の処理
            const selects = document.querySelectorAll('select[name="id"]');
            selects.forEach((select) => {
                select.addEventListener('change', (event) => {
                    common.getAddressInfo(event);
                });
            });
        }, false);
    </script>
@endsection
