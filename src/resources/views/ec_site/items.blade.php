@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '商品一覧')

{{-- ページコンテンツ --}}
@section('content')
    @if ($ecProducts->isEmpty())
        <div class="flex flex-row flex-wrap border-b-2 border-t-2 border-sky-950 py-2 dark:border-sky-50">
            <x-empty-string-box>商品がありません。</x-empty-string-box>
        </div>
    @else
        <div class="w-full py-2">
            {{ $ecProducts->render() }}
        </div>
        <div class="flex flex-row flex-wrap border-b-2 border-t-2 border-sky-950 py-2 dark:border-sky-50">
            @foreach ($ecProducts as $ecProduct)
                <form class="flex w-full flex-col gap-2 p-1 sm:w-1/2 md:w-1/3 lg:w-1/4" id="item-{{ $ecProduct->id }}"
                    action="{{ url('cart/store', null, app()->isProduction()) }}" method="POST">
                    @csrf
                    <input name="id" type="hidden" value="{{ $ecProduct->id }}">
                    <input name="name" type="hidden" value="{{ $ecProduct->name }}">
                    <div class="flex w-full basis-12 flex-row rounded-lg bg-sky-200 p-1 dark:bg-sky-700">
                        <p class="m-auto flex text-center text-xl font-bold text-sky-950 dark:text-sky-50">
                            {{ $ecProduct->name }}
                        </p>
                    </div>
                    <div class="mx-auto flex flex-row">
                        <x-image-box class="h-56 w-56" image-id="item-{{ $ecProduct->id }}-image-preview"
                            image-url="{{ url('api/product-image/' . $ecProduct->id, null, app()->isProduction()) }}"
                            image-alt="{{ $ecProduct->name }}" image-title="{{ $ecProduct->name }}" />
                    </div>
                    <div class="flex basis-full flex-row">
                        <x-input-label class="m-auto w-3/12 text-center" for="item-{{ $ecProduct->id }}-order-price"
                            :value="__('価格')" />
                        <x-text-input class="w-7/12 text-right" id="item-{{ $ecProduct->id }}-order-price"
                            name="order_price" type="number" :value="$ecProduct->price" :readonly="true" />
                        <x-input-label class="mx-auto mt-auto w-2/12 text-center"
                            for="item-{{ $ecProduct->id }}-order-price" :value="__('円')" />
                    </div>
                    <div class="flex basis-full flex-row">
                        <x-input-label class="m-auto w-3/12 text-center" for="item-{{ $ecProduct->id }}-stock-qty"
                            :value="__('在庫')" />
                        <x-text-input class="w-7/12 text-right" id="item-{{ $ecProduct->id }}-stock-qty" name="stock_qty"
                            type="number" :value="$ecProduct->qty" :readonly="true" />
                        <x-input-label class="mx-auto mt-auto w-2/12 text-center" for="item-{{ $ecProduct->id }}-stock-qty"
                            :value="__('個')" />
                    </div>
                    <div class="flex flex-col">
                        <div class="flex basis-full flex-row">
                            <x-input-label class="m-auto w-3/12 text-center" for="item-{{ $ecProduct->id }}-order-qty"
                                :value="__('注文')" />
                            <x-text-input class="mx-auto w-7/12 text-right" id="item-{{ $ecProduct->id }}-order-qty"
                                name="order_qty" type="number" :value="1" min="1"
                                max="{{ $ecProduct->qty }}" />
                            <x-input-label class="mx-auto mt-auto w-2/12 text-center"
                                for="item-{{ $ecProduct->id }}-order-qty" :value="__('点')" />
                        </div>
                        @if (old('update') == $ecProduct->id)
                            <x-input-error class="my-2" :messages="$errors->get('order_qty')" />
                        @endif
                    </div>
                    <div class="flex">
                        @if ($ecProduct->qty == 0)
                            <x-primary-button class="inline-flex h-12 basis-full flex-row justify-center gap-2"
                                name="update" title="在庫切れ" :value="$ecProduct->id" disabled>
                                <i class="fa-solid fa-minus m-auto"></i>
                                <span class="flex text-sm font-bold">在庫切れ</span>
                            </x-primary-button>
                        @else
                            <x-primary-button class="inline-flex h-12 basis-full flex-row justify-center gap-2"
                                name="update" title="カートに入れる" :value="$ecProduct->id">
                                <i class="fa-solid fa-cart-arrow-down fa-2xl flex"></i>
                                <span class="flex text-sm font-bold">カートに入れる</span>
                            </x-primary-button>
                        @endif
                    </div>
                </form>
            @endforeach
        </div>
        <div class="w-full py-2">
            {{ $ecProducts->render() }}
        </div>
    @endif
@endsection
