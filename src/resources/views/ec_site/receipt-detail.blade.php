@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '購入履歴詳細')

{{-- ページメニュー --}}
@section('menu')
    <x-link-button-box>
        <x-link-button class="basis-1/2" link-type="link" link-to="{{ url('mypage', null, app()->isProduction()) }}">
            マイページ
        </x-link-button>
        <x-link-button class="basis-1/2" link-type="link" link-to="{{ url('mypage/receipt', null, app()->isProduction()) }}">
            購入履歴
        </x-link-button>
    </x-link-button-box>
@endsection

{{-- ページコンテンツ --}}
@section('content')
    {{-- 本体 --}}
    @if ($ecReceiptDetails->isEmpty())
        <x-empty-string-box>購入履歴詳細がありません。</x-empty-string-box>
    @else
        {{-- レシート情報 --}}
        <div class="mt-4 flex flex-col gap-2 rounded-lg border-2 border-solid border-sky-950 p-4 dark:border-sky-50">
            <div class="flex w-full py-4">
                <h3 class="mx-auto flex text-center text-2xl font-bold text-sky-950 dark:text-sky-50">注文情報</h3>
            </div>
            <div class="flex flex-col gap-2 sm:flex-row">
                <div class="flex basis-full flex-col gap-1 sm:basis-2/3">
                    <x-input-label for="receipt-no" :value="__('注文番号')" />
                    <x-text-input class="mt-1 block w-full" id="receipt-no" type="text" :disabled="true"
                        :value="$ecReceipt->no" />
                </div>
                <div class="flex basis-full flex-col gap-1 sm:basis-1/3">
                    <x-input-label for="receipt-date" :value="__('注文日時')" />
                    <x-text-input class="mt-1 block w-full" id="receipt-date" type="text" :disabled="true"
                        :value="date_format(date_create($ecReceipt->date), 'Y年m月d日 H時i分s秒')" />
                </div>
            </div>
        </div>
        <div class="mt-4 flex flex-col gap-2 rounded-lg border-2 border-solid border-sky-950 p-4 dark:border-sky-50">
            <div class="flex w-full py-4">
                <h3 class="mx-auto flex text-center text-2xl font-bold text-sky-950 dark:text-sky-50">配送先情報</h3>
            </div>
            <div class="flex flex-col gap-2 sm:flex-row">
                <div class="flex basis-1/6 flex-col gap-1">
                    <x-input-label for="receipt-no" :value="__('郵便番号')" />
                    <x-text-input class="mt-1 block w-full" id="receipt-zip" type="text" :disabled="true"
                        :value="$ecReceipt->zip" />
                </div>
                <div class="flex basis-5/6 flex-col gap-1">
                    <x-input-label for="receipt-date" :value="__('住所１')" />
                    <x-text-input class="mt-1 block w-full" id="receipt-address1" type="text" :disabled="true"
                        :value="$ecReceipt->address1" />
                </div>
            </div>
            <div class="flex flex-col gap-2 sm:flex-row">
                <div class="flex basis-full flex-col gap-1">
                    <x-input-label for="receipt-date" :value="__('住所２')" />
                    <x-text-input class="mt-1 block w-full" id="receipt-address1" type="text" :disabled="true"
                        :value="$ecReceipt->address2" />
                </div>
            </div>
        </div>
        {{-- レシート情報詳細 --}}
        <div class="w-full py-2">
            {{ $ecReceiptDetails->render() }}
        </div>
        <div class="flex flex-col gap-4">
            @foreach ($ecReceiptDetails as $ecReceiptDetail)
                <div
                    class="{{ $loop->first ? 'border-t-2' : '' }} }} flex basis-full flex-row gap-2 border-b-2 border-sky-950 py-2 dark:border-sky-50">
                    <div class="flex w-full basis-full flex-col gap-2 px-1 md:flex-row">
                        <x-image-box class="w-88 h-88 basis-88 md:h-64 md:w-64 md:basis-64" :border="false"
                            image-id="detail-image-{{ $ecReceiptDetail->id }}"
                            image-url="{{ url('api/receipt-image/' . $ecReceiptDetail->receipt_id . '/' . $ecReceiptDetail->id, null, app()->isProduction()) }}"
                            image-alt="{{ $ecReceiptDetail->name }}" image-title="{{ $ecReceiptDetail->name }}">
                        </x-image-box>
                        <div class="flex grow flex-col gap-2 md:flex-row">
                            <div class="flex basis-full flex-col gap-1">
                                <div class="block">
                                    <x-input-label for="detail-name-{{ $ecReceiptDetail->id }}" :value="__('名称')" />
                                    <x-text-input class="mt-1 block w-full" id="detail-name-{{ $ecReceiptDetail->id }}"
                                        type="text" :disabled="true" :value="$ecReceiptDetail->name" />
                                </div>
                                <div class="block">
                                    <x-input-label for="detail-price-{{ $ecReceiptDetail->id }}" :value="__('価格')" />
                                    <div class="flex flex-row content-stretch gap-2">
                                        <x-text-input class="mt-1 block w-full text-right"
                                            id="detail-price-{{ $ecReceiptDetail->id }}" type="number" :disabled="true"
                                            :value="$ecReceiptDetail->price" />
                                        <x-input-label class="mt-auto" for="detail-price-{{ $ecReceiptDetail->id }}"
                                            :value="__('円')" />
                                    </div>
                                </div>
                                <div class="block">
                                    <x-input-label for="detail-qty-{{ $ecReceiptDetail->id }}" :value="__('数量')" />
                                    <div class="flex flex-row content-stretch gap-2">
                                        <x-text-input class="mt-1 block w-full text-right"
                                            id="detail-qty-{{ $ecReceiptDetail->id }}" type="number" :value="$ecReceiptDetail->qty"
                                            :disabled="true" />
                                        <x-input-label class="mt-auto" for="detail-qty-{{ $ecReceiptDetail->id }}"
                                            :value="__('点')" />
                                    </div>
                                </div>
                                <div class="block">
                                    <x-input-label for="detail-sub-total-{{ $ecReceiptDetail->id }}" :value="__('小計')" />
                                    <div class="flex flex-row content-stretch gap-2">
                                        <x-text-input class="mt-1 block w-full text-right"
                                            id="detail-sub-total-{{ $ecReceiptDetail->id }}" type="number"
                                            :disabled="true" :value="$ecReceiptDetail->price * $ecReceiptDetail->qty" />
                                        <x-input-label class="mt-auto" for="detail-sub-total-{{ $ecReceiptDetail->id }}"
                                            :value="__('円')" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="w-full py-2">
            {{ $ecReceiptDetails->render() }}
        </div>
        {{-- トータル --}}
        <x-total-display :total-qty="$ecReceipt->qty" :total-amount="$ecReceipt->amount"></x-total-display>
    @endif
@endsection
