@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '商品一覧')

{{-- ページコンテンツ --}}
@section('content')
    @if ($ecProducts->isEmpty())
        <div class="flex flex-row flex-wrap py-2 border-t-2 border-b-2 border-sky-950 dark:border-sky-50">
            <x-empty-string-box>商品がありません。</x-empty-string-box>
        </div>
    @else
        <div class="w-full pb-2">
            {{ $ecProducts->render() }}
        </div>
        <div class="flex flex-row flex-wrap py-2 border-t-2 border-b-2 border-sky-950 dark:border-sky-50">
            @foreach ($ecProducts as $ecProduct)
                <div class="flex flex-col basis-full sm:basis-1/2 md:basis-1/3 lg:basis-1/4 p-2 gap-2">
                    <div class="flex flex-row w-full p-2 rounded-lg bg-sky-200 dark:bg-sky-700">
                        <p class="flex m-auto text-center text-xl text-sky-950 dark:text-sky-50 font-bold">
                            {{ $ecProduct->name }}
                        </p>
                    </div>
                    <div class="flex flex-row basis-full sm:basis-1/2 md:basis-1/3 lg:basis-1/4 h- mx-auto">
                        <x-image-box class="w-56 h-56" image-id="item-{{ $ecProduct->id }}-image-preview"
                            image-type="{{ $ecProduct->image_type }}" image-data="{{ $ecProduct->image_data }}"
                            image-alt="{{ $ecProduct->name }}" image-title="{{ $ecProduct->name }}" />
                    </div>
                    <form class="flex flex-col gap-2 w-full" id="item-{{ $ecProduct->id }}"
                        action="{{ url('/items/store', null, app()->isProduction()) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $ecProduct->id }}">
                        <input type="hidden" name="name" value="{{ $ecProduct->name }}">
                        <div class="flex flex-row mx-2">
                            <x-input-label class="w-3/12 m-auto text-center" for="item-{{ $ecProduct->id }}-order-price"
                                :value="__('価格')" />
                            <x-text-input class="w-7/12 text-right" type="number"
                                id="item-{{ $ecProduct->id }}-order-price" name="order_price" :value="$ecProduct->price"
                                :readonly="true" />
                            <x-input-label class="w-2/12 mt-auto mx-auto text-center"
                                for="item-{{ $ecProduct->id }}-order-price" :value="__('円')" />
                        </div>
                        <div class="flex flex-row mx-2">
                            <x-input-label class="w-3/12 m-auto text-center" for="item-{{ $ecProduct->id }}-stock-qty"
                                :value="__('在庫')" />
                            <x-text-input class="w-7/12 text-right" type="number" id="item-{{ $ecProduct->id }}-stock-qty"
                                name="stock_qty" :value="$ecProduct->qty" :readonly="true" />
                            <x-input-label class="w-2/12 mt-auto mx-auto text-center"
                                for="item-{{ $ecProduct->id }}-stock-qty" :value="__('個')" />
                        </div>
                        <div class="flex flex-col">
                            <div class="flex flex-row mx-2">
                                <x-input-label class="w-3/12 m-auto text-center" for="item-{{ $ecProduct->id }}-order-qty"
                                    :value="__('注文')" />
                                <x-text-input class="w-7/12 text-right" type="number"
                                    id="item-{{ $ecProduct->id }}-order-qty" name="order_qty" :value="1"
                                    min="1" max="{{ $ecProduct->qty }}" />
                                <x-input-label class="w-2/12 mt-auto mx-auto text-center"
                                    for="item-{{ $ecProduct->id }}-order-qty" :value="__('点')" />
                            </div>
                            @if (old('update') == $ecProduct->id)
                                <x-input-error :messages="$errors->get('order_qty')" class="my-2" />
                            @endif
                        </div>
                        <div class="flex mx-2">
                            @if ($ecProduct->qty == 0)
                                <x-primary-button class="flex flex-row justify-center gap-2 w-full h-8" name="update"
                                    :value="$ecProduct->id" disabled title="在庫切れ">
                                    <i class="m-auto fa-solid fa-minus"></i>
                                    <span class="flex text-sm font-bold">在庫切れ</span>
                                </x-primary-button>
                            @else
                                <x-primary-button class="flex flex-row justify-center gap-2 w-full h-8" name="update"
                                    :value="$ecProduct->id" title="カートに入れる">
                                    <i class="flex fa-solid fa-cart-arrow-down fa-2xl"></i>
                                    <span class="flex text-sm font-bold">カートに入れる</span>
                                </x-primary-button>
                            @endif
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
        <div class="w-full pt-2">
            {{ $ecProducts->render() }}
        </div>
    @endif
@endsection
