@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '商品一覧')

{{-- ページコンテンツ --}}
@section('content')
    <div class="flex flex-row flex-wrap">
        @foreach ($ec_products as $ec_product)
            <div class="flex flex-col basis-1/4">
                <form class="flex flex-col" id="item-{{ $ec_product->id }}" action="{{ route('items.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="item-{{ $ec_product->id }}-id" value="{{ $ec_product->id }}">
                    <input type="hidden" name="item-{{ $ec_product->id }}-name" value="{{ $ec_product->name }}">
                    <div class="flex flex-row">
                        <p class="text-center text-xl font-bold">{{ $ec_product->name }}</p>
                    </div>
                    <div class="flex basis-60 h-60 shrink grow-0 mx-auto">
                        <img class="block object-center object-cover overflow-hidden"
                            src="data:{{ $ec_product->product_image_type }};base64,{{ $ec_product->product_image_data }}">
                    </div>
                    <div class="flex flex-row">
                        <x-input-label class="flex m-auto text-left" for="item-{{ $ec_product->id }}-price"
                            :value="__('価格')" />
                        <x-text-input class="flex text-right" type="number" id="item-{{ $ec_product->id }}-price"
                            name="price" :value="$ec_product->price" :disabled="true" />
                        <x-input-label class="flex mt-auto mx-auto text-right" for="item-{{ $ec_product->id }}-price"
                            :value="__('円')" />
                    </div>
                    <div class="flex flex-row">
                        <x-input-label class="flex m-auto text-left" for="item-{{ $ec_product->id }}-qty"
                            :value="__('在庫')" />
                        <x-text-input class="flex text-right" type="number" id="item-{{ $ec_product->id }}-qty"
                            name="qty" :value="$ec_product->qty" :disabled="true" />
                        <x-input-label class="flex mt-auto mx-auto text-right" for="item-{{ $ec_product->id }}-qty"
                            :value="__('個')" />
                    </div>
                    <div class="flex flex-row">
                        <x-input-label class="flex m-auto text-left" for="item-{{ $ec_product->id }}-order-qty"
                            :value="__('注文')" />
                        <x-text-input class="flex text-right" type="number" id="item-{{ $ec_product->id }}-order-qty"
                            name="order-qty" :value="0" />
                        <x-input-label class="flex mt-auto mx-auto text-right" for="item-{{ $ec_product->id }}-order-qty"
                            :value="__('個')" />
                    </div>
                    <div class="flex">
                        @if ($ec_product->qty == 0)
                            <x-primary-button class="w-full" name="update" :value="$ec_product->id">
                                <i class="m-auto fa-solid fa-minus"></i>
                            </x-primary-button>
                        @else
                            <x-primary-button class="w-full" name="update" :value="$ec_product->id">
                                <i class="m-auto fa-solid fa-cart-arrow-down fa-2xl" alt="カートに入れる"></i>
                            </x-primary-button>
                        @endif
                    </div>
                </form>
            </div>
        @endforeach
    </div>
    <div class="container">
        {{ $ec_products->render() }}
    </div>
@endsection
