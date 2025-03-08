@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '購入履歴詳細')

{{-- ページコンテンツ --}}
@section('content')
    {{-- ヘッダー --}}
    <x-link-button-box>
        <x-link-button class="basis-full" link-type="link" link-to="{{ url('mypage/receipt', null, app()->isProduction()) }}">
            購入履歴
        </x-link-button>
    </x-link-button-box>
    {{-- 本体 --}}
    @if ($ecReceiptDetails->isEmpty())
        <x-empty-string-box>購入履歴詳細がありません。</x-empty-string-box>
    @else
        {{-- レシート情報 --}}
        <div class="flex flex-col gap-2 my-4 p-4 border-solid border-2 rounded-lg border-sky-950 dark:border-sky-50">
            <div class="flex w-full py-4">
                <h3 class="flex mx-auto text-2xl text-center font-bold text-sky-950 dark:text-sky-50">購入情報</h3>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <div class="flex flex-col basis-full gap-1">
                    <x-input-label for="receipt-no" :value="__('注文番号')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="receipt-no" :disabled="true"
                        :value="$ecReceipt->no" />
                </div>
                <div class="flex flex-col basis-full gap-1">
                    <x-input-label for="receipt-date" :value="__('注文日時')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="receipt-date" :disabled="true"
                        :value="date_format(date_create($ecReceipt->date), 'Y年m月d日 H時i分s秒')" />
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <div class="flex flex-col basis-full gap-1">
                    <x-input-label for="receipt-qty" :value="__('注文数量')" />
                    <div class="flex flex-row content-stretch gap-2">
                        <x-text-input class="block mt-1 w-full text-right" type="text" id="receipt-qty" :disabled="true"
                            :value="number_format($ecReceipt->qty)" />
                        <x-input-label class="mt-auto" for="receipt-qty" :value="__('点')" />
                    </div>
                </div>
                <div class="flex flex-col basis-full gap-1">
                    <x-input-label for="receipt-amount" :value="__('注文金額')" />
                    <div class="flex flex-row content-stretch gap-2">
                        <x-text-input class="block mt-1 w-full text-right" type="text" id="receipt-amount"
                            :disabled="true" :value="number_format($ecReceipt->amount)" />
                        <x-input-label class="mt-auto" for="receipt-amount" :value="__('円')" />
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-2 my-4 p-4 border-solid border-2 rounded-lg border-sky-950 dark:border-sky-50">
            <div class="flex w-full py-4">
                <h3 class="flex mx-auto text-2xl text-center font-bold text-sky-950 dark:text-sky-50">配送先情報</h3>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <div class="flex flex-col basis-1/6 gap-1">
                    <x-input-label for="receipt-no" :value="__('郵便番号')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="receipt-zip" :disabled="true"
                        :value="$ecReceipt->zip" />
                </div>
                <div class="flex flex-col basis-5/6 gap-1">
                    <x-input-label for="receipt-date" :value="__('住所１')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="receipt-address1" :disabled="true"
                        :value="$ecReceipt->address1" />
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <div class="flex flex-col basis-full gap-1">
                    <x-input-label for="receipt-date" :value="__('住所２')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="receipt-address1" :disabled="true"
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
                    class="flex flex-row basis-full gap-2 py-2 {{ $loop->first ? 'border-t-2' : '' }} border-b-2 border-sky-950 dark:border-sky-50  }}">
                    <div class="flex flex-col md:flex-row basis-full w-full gap-2 px-1">
                        <x-image-box class="w-88 md:w-64 h-88 md:h-64 basis-88 md:basis-64" :border="false"
                            image-id="detail-image-{{ $ecReceiptDetail->id }}"
                            image-url="{{ url('api/receipt-image/' . $ecReceiptDetail->receipt_id . '/' . $ecReceiptDetail->id, null, app()->isProduction()) }}"
                            image-alt="{{ $ecReceiptDetail->name }}" image-title="{{ $ecReceiptDetail->name }}">
                        </x-image-box>
                        <div class="flex flex-col md:flex-row grow gap-2">
                            <div class="flex flex-col basis-full gap-1">
                                <div class="block">
                                    <x-input-label for="detail-name-{{ $ecReceiptDetail->id }}" :value="__('名称')" />
                                    <x-text-input class="block mt-1 w-full" type="text"
                                        id="detail-name-{{ $ecReceiptDetail->id }}" :disabled="true" :value="$ecReceiptDetail->name" />
                                </div>
                                <div class="block">
                                    <x-input-label for="detail-price-{{ $ecReceiptDetail->id }}" :value="__('価格')" />
                                    <div class="flex flex-row content-stretch gap-2">
                                        <x-text-input class="block mt-1 w-full text-right" type="number"
                                            id="detail-price-{{ $ecReceiptDetail->id }}" :disabled="true"
                                            :value="$ecReceiptDetail->price" />
                                        <x-input-label class="mt-auto" for="detail-price-{{ $ecReceiptDetail->id }}"
                                            :value="__('円')" />
                                    </div>
                                </div>
                                <div class="block">
                                    <x-input-label for="detail-qty-{{ $ecReceiptDetail->id }}" :value="__('数量')" />
                                    <div class="flex flex-row content-stretch gap-2">
                                        <x-text-input class="block mt-1 w-full text-right" type="number"
                                            id="detail-qty-{{ $ecReceiptDetail->id }}" :value="$ecReceiptDetail->qty"
                                            :disabled="true" />
                                        <x-input-label class="mt-auto" for="detail-qty-{{ $ecReceiptDetail->id }}"
                                            :value="__('点')" />
                                    </div>
                                </div>
                                <div class="block">
                                    <x-input-label for="detail-sub-total-{{ $ecReceiptDetail->id }}" :value="__('小計')" />
                                    <div class="flex flex-row content-stretch gap-2">
                                        <x-text-input class="block mt-1 w-full text-right" type="number"
                                            id="detail-sub-total-{{ $ecReceiptDetail->id }}" :disabled="true"
                                            :value="$ecReceiptDetail->price * $ecReceiptDetail->qty" />
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
    {{-- フッター --}}
    <x-link-button-box>
        <x-link-button class="basis-full" link-type="link"
            link-to="{{ url('mypage/receipt', null, app()->isProduction()) }}">
            購入履歴
        </x-link-button>
    </x-link-button-box>
@endsection
