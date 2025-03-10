@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '購入履歴')

{{-- ページコンテンツ --}}
@section('content')
    {{-- ヘッダー --}}
    <x-link-button-box>
        <x-link-button class="basis-full" link-type="link" link-to="{{ url('mypage', null, app()->isProduction()) }}">
            マイページ
        </x-link-button>
    </x-link-button-box>
    {{-- 本体 --}}
    @if ($ecReceipts->isEmpty())
        <x-empty-string-box>購入履歴がありません。</x-empty-string-box>
    @else
        <div class="w-full py-2">
            {{ $ecReceipts->render() }}
        </div>
        <div class="flex flex-col basis-full">
            @foreach ($ecReceipts as $ecReceipt)
                <div
                    class="flex flex-col sm:flex-row basis-full gap-2 py-2 {{ $loop->first ? 'border-t-2' : '' }} border-b-2 border-sky-950 dark:border-sky-50">
                    <div class="flex flex-col basis-5/6 w-full gap-2 px-1">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <div class="flex flex-col basis-full gap-1">
                                <x-input-label for="receipt-no" :value="__('注文番号')" />
                                <x-text-input class="block mt-1 w-full" type="text" id="receipt-no" :disabled="true"
                                    :value="$ecReceipt->no" />
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2">
                            <div class="flex flex-col basis-full sm:basis-2/4 gap-1">
                                <x-input-label for="receipt-date" :value="__('注文日時')" />
                                <x-text-input class="block mt-1 w-full" type="text" id="receipt-date" :disabled="true"
                                    :value="date_format(date_create($ecReceipt->date), 'Y年m月d日 H時i分s秒')" />
                            </div>
                            <div class="flex flex-col basis-full sm:basis-1/4 gap-1">
                                <x-input-label for="receipt-qty" :value="__('注文数量')" />
                                <div class="flex flex-row content-stretch gap-2">
                                    <x-text-input class="block mt-1 w-full text-right" type="text" id="receipt-qty"
                                        :disabled="true" :value="number_format($ecReceipt->qty)" />
                                    <x-input-label class="mt-auto" for="receipt-qty" :value="__('点')" />
                                </div>
                            </div>
                            <div class="flex flex-col basis-full sm:basis-1/4 gap-1">
                                <x-input-label for="receipt-amount" :value="__('注文金額')" />
                                <div class="flex flex-row content-stretch gap-2">
                                    <x-text-input class="block mt-1 w-full text-right" type="text" id="receipt-amount"
                                        :disabled="true" :value="number_format($ecReceipt->amount)" />
                                    <x-input-label class="mt-auto" for="receipt-amount" :value="__('円')" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <x-link-button-box class="basis-1/6 w-full">
                        <x-link-button class="basis-full w-full" link-type="link"
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
    {{-- フッター --}}
    <x-link-button-box>
        <x-link-button class="basis-full" link-type="link" link-to="{{ url('mypage', null, app()->isProduction()) }}">
            マイページ
        </x-link-button>
    </x-link-button-box>
@endsection
