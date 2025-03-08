@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '購入確認')

{{-- ページコンテンツ --}}
@section('content')
    @if ($ecCartDetails->isEmpty())
        {{-- ヘッダー --}}
        <x-link-button-box>
            <x-link-button class="basis-full" link-type="link" link-to="{{ url('items', null, app()->isProduction()) }}">
                商品一覧
            </x-link-button>
        </x-link-button-box>
        {{-- 本体 --}}
        <x-empty-string-box>商品がありません。</x-empty-string-box>
        {{-- フッター --}}
        <x-link-button-box>
            <x-link-button class="basis-full" link-type="link" link-to="{{ url('items', null, app()->isProduction()) }}">
                商品一覧
            </x-link-button>
        </x-link-button-box>
    @else
        {{-- ヘッダー --}}
        <x-link-button-box>
            <x-link-button class="basis-1/3" link-type="link" link-to="{{ url('items', null, app()->isProduction()) }}">
                商品一覧
            </x-link-button>
            <x-link-button class="basis-1/3" link-type="link" link-to="{{ url('cart', null, app()->isProduction()) }}">
                カートに戻る
            </x-link-button>
            <x-link-button class="basis-1/3" link-type="form"
                link-to="{{ url('confirm/store', null, app()->isProduction()) }}">
                購入する
            </x-link-button>
        </x-link-button-box>
        {{-- 購入情報 --}}
        <div class="flex flex-col gap-2 my-4 p-4 border-solid border-2 rounded-lg border-sky-950 dark:border-sky-50">
            <div class="flex w-full py-4">
                <h3 class="flex mx-auto text-2xl text-center font-bold text-sky-950 dark:text-sky-50">配送先情報</h3>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <div class="flex flex-col basis-1/6 gap-1">
                    <x-input-label for="cart-no" :value="__('郵便番号')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="cart-zip" :disabled="true"
                        :value="$ecCart->ec_addresses->zip" />
                </div>
                <div class="flex flex-col basis-5/6 gap-1">
                    <x-input-label for="cart-date" :value="__('住所１')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="cart-address1" :disabled="true"
                        :value="$ecCart->ec_addresses->ec_prefs->name . $ecCart->ec_addresses->address1" />
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <div class="flex flex-col basis-full gap-1">
                    <x-input-label for="cart-date" :value="__('住所２')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="cart-address1" :disabled="true"
                        :value="$ecCart->ec_addresses->address2" />
                </div>
            </div>
        </div>
        {{-- 購入情報詳細 --}}
        <div class="w-full py-2">
            {{ $ecCartDetails->render() }}
        </div>
        <div class="flex flex-col">
            @foreach ($ecCartDetails as $ecCartDetail)
                <div
                    class="flex flex-row basis-full gap-2 py-4 {{ $loop->first ? 'pt-4 border-t-2' : '' }} border-b-2 border-sky-950 dark:border-sky-50">
                    <div class="flex flex-col md:flex-row basis-full w-full gap-2 px-1">
                        <x-image-box class="w-88 md:w-64 h-88 md:h-64 basis-88 md:basis-64" :border="false"
                            image-id="detail-image-{{ $ecCartDetail->id }}"
                            image-url="{{ url('api/product-image/' . $ecCartDetail->product_id, null, app()->isProduction()) }}"
                            image-alt="{{ $ecCartDetail->ec_products->name }}"
                            image-title="{{ $ecCartDetail->ec_products->name }}">
                        </x-image-box>
                        <div class="flex flex-col md:flex-row grow gap-2">
                            <div class="flex flex-col basis-full gap-1">
                                <div class="block">
                                    <x-input-label for="detail-name-{{ $ecCartDetail->id }}" :value="__('名称')" />
                                    <x-text-input class="block mt-1 w-full" type="text"
                                        id="detail-name-{{ $ecCartDetail->id }}" :disabled="true" :value="$ecCartDetail->ec_products->name" />
                                </div>
                                <div class="block">
                                    <x-input-label for="detail-price-{{ $ecCartDetail->id }}" :value="__('価格')" />
                                    <div class="flex flex-row content-stretch gap-2">
                                        <x-text-input class="block mt-1 w-full text-right" type="number"
                                            id="detail-price-{{ $ecCartDetail->id }}" :disabled="true"
                                            :value="$ecCartDetail->price" />
                                        <x-input-label class="mt-auto" for="detail-price-{{ $ecCartDetail->id }}"
                                            :value="__('円')" />
                                    </div>
                                </div>
                                <div class="block">
                                    <x-input-label for="detail-qty-{{ $ecCartDetail->id }}" :value="__('数量')" />
                                    <div class="flex flex-row content-stretch gap-2">
                                        <x-text-input class="block mt-1 w-full text-right" type="number"
                                            id="detail-qty-{{ $ecCartDetail->id }}" :value="$ecCartDetail->qty"
                                            :disabled="true" />
                                        <x-input-label class="mt-auto" for="detail-qty-{{ $ecCartDetail->id }}"
                                            :value="__('点')" />
                                    </div>
                                </div>
                                <div class="block">
                                    <x-input-label for="detail-sub-total-{{ $ecCartDetail->id }}" :value="__('小計')" />
                                    <div class="flex flex-row content-stretch gap-2">
                                        <x-text-input class="block mt-1 w-full text-right" type="number"
                                            id="detail-sub-total-{{ $ecCartDetail->id }}" :disabled="true"
                                            :value="$ecCartDetail->price * $ecCartDetail->qty" />
                                        <x-input-label class="mt-auto" for="detail-sub-total-{{ $ecCartDetail->id }}"
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
            {{ $ecCartDetails->render() }}
        </div>
        {{-- トータル --}}
        <x-total-display :total-qty="$ecCartTotal->total_qty" :total-amount="$ecCartTotal->total_amount"></x-total-display>
        {{-- フッター --}}
        <x-link-button-box>
            <x-link-button class="basis-1/3" link-type="link" link-to="{{ url('items', null, app()->isProduction()) }}">
                商品一覧
            </x-link-button>
            <x-link-button class="basis-1/3" link-type="link" link-to="{{ url('cart', null, app()->isProduction()) }}">
                カートに戻る
            </x-link-button>
            <x-link-button class="basis-1/3" link-type="form"
                link-to="{{ url('confirm/store', null, app()->isProduction()) }}">
                購入する
            </x-link-button>
        </x-link-button-box>
    @endif
@endsection
