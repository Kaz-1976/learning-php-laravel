@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '購入履歴')

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
    @if ($ecReceipts->isEmpty())
        <x-empty-string-box>購入履歴がありません。</x-empty-string-box>
    @else
        <div class="w-full py-2">
            {{ $ecReceipts->render() }}
        </div>
        <div class="flex basis-full flex-col">
            @foreach ($ecReceipts as $ecReceipt)
                <div
                    class="{{ $loop->first ? 'border-t-2' : '' }} flex basis-full flex-col gap-2 border-b-2 border-sky-950 py-2 sm:flex-row dark:border-sky-50">
                    <div class="flex w-full basis-5/6 flex-col gap-2 px-1">
                        <div class="flex flex-col gap-2 sm:flex-row">
                            <div class="flex basis-full flex-col gap-1">
                                <x-input-label for="receipt-no" :value="__('注文番号')" />
                                <x-text-input class="mt-1 block w-full" id="receipt-no" type="text" :disabled="true"
                                    :value="$ecReceipt->no" />
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 sm:flex-row">
                            <div class="flex basis-full flex-col gap-1 sm:basis-2/4">
                                <x-input-label for="receipt-date" :value="__('注文日時')" />
                                <x-text-input class="mt-1 block w-full" id="receipt-date" type="text" :disabled="true"
                                    :value="date_format(date_create($ecReceipt->date), 'Y年m月d日 H時i分s秒')" />
                            </div>
                            <div class="flex basis-full flex-col gap-1 sm:basis-1/4">
                                <x-input-label for="receipt-qty" :value="__('注文数量')" />
                                <div class="flex flex-row content-stretch gap-2">
                                    <x-text-input class="mt-1 block w-full text-right" id="receipt-qty" type="text"
                                        :disabled="true" :value="number_format($ecReceipt->qty)" />
                                    <x-input-label class="mt-auto" for="receipt-qty" :value="__('点')" />
                                </div>
                            </div>
                            <div class="flex basis-full flex-col gap-1 sm:basis-1/4">
                                <x-input-label for="receipt-amount" :value="__('注文金額')" />
                                <div class="flex flex-row content-stretch gap-2">
                                    <x-text-input class="mt-1 block w-full text-right" id="receipt-amount" type="text"
                                        :disabled="true" :value="number_format($ecReceipt->amount)" />
                                    <x-input-label class="mt-auto" for="receipt-amount" :value="__('円')" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <x-link-button-box class="w-full basis-1/6">
                        <x-link-button class="w-full basis-full" link-type="link"
                            link-to="{{ url('mypage/receipt/' . $ecReceipt->id, null, app()->isProduction()) }}">
                            詳細
                        </x-link-button>
                    </x-link-button-box>
                </div>
            @endforeach
        </div>
        <div class="w-full py-2">
            {{ $ecReceipts->render() }}
        </div>
    @endif
@endsection
