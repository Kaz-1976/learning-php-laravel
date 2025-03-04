@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '決済完了')

{{-- ページコンテンツ --}}
@section('content')
    {{-- ヘッダー --}}
    <x-link-button-box>
        <x-link-button class="basis-full" link-type="link" link-to="/items">商品一覧</x-link-button>
    </x-link-button-box>
    {{-- 本体 --}}
    @if (empty($ecReceipt))
        <x-empty-string-box>購入商品がありません。</x-empty-string-box>
    @else
        <div class="flex flex-col">
            {{-- ページネーション（上） --}}
            <div class="w-full pb-2">
                {{ $ecReceiptDetails->render() }}
            </div>
            {{-- 繰り返し表示 --}}
            <div class="flex flex-col">
                @foreach ($ecReceiptDetails as $ecReceiptDetail)
                    <div
                        class="flex flex-row basis-full gap-2 py-2 {{ $loop->first ? 'border-t-2' : '' }} border-b-2 border-sky-950 dark:border-sky-50 {{ $ecReceiptDetail->public_flg ? 'bg-sky-400 dark:bg-sky-700' : 'bg-sky-200 dark:bg-sky-900' }}">
                        <div class="flex flex-col md:flex-row basis-full w-full gap-2 px-1">
                            <x-image-box class="w-88 md:w-64 h-88 md:h-64 basis-88 md:basis-64" :border="true"
                                image-id="update-{{ $ecReceiptDetail->id }}-image-preview"
                                image-type="{{ $ecReceiptDetail->image_type }}"
                                image-data="{{ $ecReceiptDetail->image_data }}">
                            </x-image-box>
                            <div class="flex flex-col md:flex-row grow gap-2">
                                <div class="flex flex-col basis-full gap-1">
                                    <div class="block">
                                        <x-input-label for="update-{{ $ecReceiptDetail->id }}-name" :value="__('名称')" />
                                        <x-text-input class="block mt-1 w-full" type="text"
                                            id="update-{{ $ecReceiptDetail->id }}-name" :disabled="true"
                                            :value="$ecReceiptDetail->ec_products->name" />
                                    </div>
                                    <div class="block">
                                        <x-input-label for="update-{{ $ecReceiptDetail->id }}-price" :value="__('価格')" />
                                        <div class="flex flex-row content-stretch gap-2">
                                            <x-text-input class="block mt-1 w-full text-right" type="number"
                                                id="update-{{ $ecReceiptDetail->id }}-price" :disabled="true"
                                                :value="$ecReceiptDetail->price" />
                                            <x-input-label class="mt-auto" for="update-{{ $ecReceiptDetail->id }}-price"
                                                :value="__('円')" />
                                        </div>
                                    </div>
                                    <div class="block">
                                        <x-input-label for="update-{{ $ecReceiptDetail->id }}-qty" :value="__('数量')" />
                                        <div class="flex flex-row content-stretch gap-2">
                                            <x-text-input class="block mt-1 w-full text-right" type="number"
                                                id="update-{{ $ecReceiptDetail->id }}-qty" :value="$ecReceiptDetail->qty"
                                                :disabled="true" />
                                            <x-input-label class="mt-auto" for="update-{{ $ecReceiptDetail->id }}-qty"
                                                :value="__('点')" />
                                        </div>
                                    </div>
                                    <div class="block">
                                        <x-input-label for="update-{{ $ecReceiptDetail->id }}-sub-total"
                                            :value="__('小計')" />
                                        <div class="flex flex-row content-stretch gap-2">
                                            <x-text-input class="block mt-1 w-full text-right" type="number"
                                                id="update-{{ $ecReceiptDetail->id }}-sub-total" :disabled="true"
                                                :value="$ecReceiptDetail->price * $ecReceiptDetail->qty" />
                                            <x-input-label class="mt-auto"
                                                for="update-{{ $ecReceiptDetail->id }}-sub-total" :value="__('円')" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- ページネーション（下） --}}
            <div class="w-full pt-2">
                {{ $ecReceiptDetails->render() }}
            </div>
            {{-- トータル --}}
            <x-total-display :total-qty="$ecReceipt->qty" :total-price="$ecReceipt->amount"></x-total-display>
        </div>
    @endif
    {{-- フッター --}}
    <x-link-button-box>
        <x-link-button class="basis-full" link-type="link" link-to="/items">商品一覧</x-link-button>
    </x-link-button-box>
@endsection
