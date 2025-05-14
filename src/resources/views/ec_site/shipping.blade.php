@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '配送先設定')

{{-- ページコンテンツ --}}
@section('content')
    <div class="flex flex-col gap-4">
        <form class="flex flex-col gap-4 rounded-lg border-2 border-solid border-sky-950 p-4 dark:border-sky-50"
            id="register" action="{{ url('shipping/store', null, app()->isProduction()) }}" method="POST">
            @csrf
            {{-- 宛先名 --}}
            <div class="flex basis-full flex-row gap-2">
                <div class="flex basis-1/2 flex-col justify-stretch">
                    <select class="" id="id" name="id" required>
                        <option value="" selected>宛先を選択してください</option>
                        @foreach ($ecAddresses as $ecAddress)
                            <option value="{{ $ecAddress->id }}">
                                {{ $ecAddress->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="my-auto flex basis-1/2 flex-row">
                    <x-primary-button class="flex basis-full" name="register-select" form="register" :value="0">
                        <span class="m-auto flex text-center text-base font-bold md:text-xl">{{ __('決定') }}</span>
                    </x-primary-button>
                </div>
            </div>
            <div class="flex basis-full flex-row gap-2">
                {{-- 郵便番号 --}}
                <div class="flex basis-1/3 flex-col justify-stretch">
                    <x-input-label for="zip" :value="__('郵便番号')" />
                    <x-text-input class="mt-1 block w-full" id="zip" name="zip" type="text" :value="''"
                        :disabled="true" />
                </div>
                {{-- 都道府県 --}}
                <div class="flex basis-2/3 flex-col justify-stretch">
                    <x-input-label for="pref" :value="__('都道府県')" />
                    <x-text-input class="mt-1 block w-full" id="pref" name="pref" type="text" :value="''"
                        :disabled="true" />
                </div>
            </div>
            {{-- 住所１ --}}
            <div class="flex basis-full flex-row gap-2">
                <div class="flex basis-full flex-col justify-stretch">
                    <x-input-label for="address1" :value="__('住所１')" />
                    <x-text-input class="mt-1 flex w-full" id="address1" name="address1" type="text" :value="''"
                        :disabled="true" />
                </div>
            </div>
            {{-- 住所２ --}}
            <div class="flex basis-full flex-row gap-2">
                <div class="flex basis-full flex-col justify-stretch">
                    <x-input-label for="address2" :value="__('住所２')" />
                    <x-text-input class="mt-1 flex w-full" id="address2" name="address2" type="text" :value="''"
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
                    common.getAddressInfo(event, {{ Auth::user()->id }});
                });
            });
        }, false);
    </script>
@endsection
