@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '商品一覧')

{{-- ページコンテンツ --}}
@section('content')
    <div class="w-full p-2">
        {{ $ec_products->render() }}
    </div>
    <div class="flex flex-row flex-wrap py-2 border-t-2 border-b-2 border-sky-950 dark:border-sky-50">
        @foreach ($ec_products as $ec_product)
            <div class="flex flex-col basis-full sm:basis-1/2 md:basis-1/3 lg:basis-1/4 p-2 gap-2">
                <div class="flex flex-row w-full p-2 rounded-lg bg-sky-200 dark:bg-sky-700">
                    <p class="flex m-auto text-center text-xl text-sky-950 dark:text-sky-50 font-bold">
                        {{ $ec_product->product_name }}
                    </p>
                </div>
                <div class="flex flex-row basis-full sm:basis-1/2 md:basis-1/3 lg:basis-1/4 mx-auto">
                    <div class="w-full max-w-72 justify-center align-middle">
                        <img class="w-56 h-56 top-0 bottom-0 left-0 right-0 object-cover overflow-hidden"
                            src="data:{{ $ec_product->product_image_type }};base64,{{ $ec_product->product_image_data }}">
                    </div>
                </div>
                <form class="flex flex-col w-full gap-2" id="item-{{ $ec_product->id }}"
                    action="{{ route('items.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="item-{{ $ec_product->id }}-id" value="{{ $ec_product->id }}">
                    <input type="hidden" name="item-{{ $ec_product->id }}-name" value="{{ $ec_product->product_name }}">
                    <div class="flex flex-row mx-2">
                        <x-input-label class="w-3/12 m-auto text-center" for="item-{{ $ec_product->id }}-price"
                            :value="__('価格')" />
                        <x-text-input class="w-7/12 text-right" type="number" id="item-{{ $ec_product->id }}-price"
                            name="price" :value="$ec_product->price" :disabled="true" />
                        <x-input-label class="w-2/12 mt-auto mx-auto text-center" for="item-{{ $ec_product->id }}-price"
                            :value="__('円')" />
                    </div>
                    <div class="flex flex-row mx-2">
                        <x-input-label class="w-3/12 m-auto text-center" for="item-{{ $ec_product->id }}-qty"
                            :value="__('在庫')" />
                        <x-text-input class="w-7/12 text-right" type="number" id="item-{{ $ec_product->id }}-qty"
                            name="qty" :value="$ec_product->qty" :disabled="true" />
                        <x-input-label class="w-2/12 mt-auto mx-auto text-center" for="item-{{ $ec_product->id }}-qty"
                            :value="__('個')" />
                    </div>
                    <div class="flex flex-row mx-2">
                        <x-input-label class="w-3/12 m-auto text-center" for="item-{{ $ec_product->id }}-order-qty"
                            :value="__('注文')" />
                        <x-text-input class="w-7/12 text-right" type="number" id="item-{{ $ec_product->id }}-order-qty"
                            name="order-qty" :value="1" />
                        <x-input-label class="w-2/12 mt-auto mx-auto text-center"
                            for="item-{{ $ec_product->id }}-order-qty" :value="__('個')" />
                    </div>
                    <div class="flex mx-2">
                        @if ($ec_product->qty == 0)
                            <x-primary-button class="w-full h-8" name="update" :value="$ec_product->id">
                                <i class="m-auto fa-solid fa-minus"></i>
                            </x-primary-button>
                        @else
                            <x-primary-button class="w-full h-8" name="update" :value="$ec_product->id">
                                <i class="m-auto fa-solid fa-cart-arrow-down fa-2xl" alt="カートに入れる"></i>
                            </x-primary-button>
                        @endif
                    </div>
                </form>
            </div>
        @endforeach
    </div>
    <div class="w-full p-2">
        {{ $ec_products->render() }}
    </div>
@endsection
