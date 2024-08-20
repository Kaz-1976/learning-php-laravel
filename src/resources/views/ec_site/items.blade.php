@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '商品一覧')

{{-- ページコンテンツ --}}
@section('content')
    @foreach ($products as $product)
        <div>
            <div>
                <p>{{ $product->name }}</p>
            </div>
            <div>
                <img src="data:{{ $ec_product->product_image_type }};base64,{{ $ec_product->product_image_data }}">
            </div>
            <div>
                <form id="item-{{ $product->id }}" action="{{ route('items.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <input type="hidden" name="name" value="{{ $product->name }}">
                    <div class="list-name">
                        <x-input-label for="register-price" :value="__('価格')" />
                        <x-text-input class="block mt-1 w-full text-right" type="number" id="item-price" name="price"
                            :value="$ec_product->price" :readonly="true" />
                        <x-input-label class="mt-auto" for="register-qty" :value="__('円')" />
                    </div>
                    <div class="list-name">
                        <x-input-label for="register-price" :value="__('在庫')" />
                        <x-text-input class="block mt-1 w-full text-right" type="number" id="item-qty" name="qty"
                            :value="$ec_product->qty" :readonly="true" />
                        <x-input-label class="mt-auto" for="register-qty" :value="__('個')" />
                    </div>
                    <div class="list-input">
                        <label class="ec-label-list" for="list-form-qty-<?php echo $item['product_id']; ?>">数量</label>
                        <div class="ec-input-list">
                            <input class="ec-input-number" id="list-form-qty-<?php echo $item['product_id']; ?>" type="number"
                                name="list-order-qty" value="1" <?php echo $item['qty'] === 0 ? 'disabled' : ''; ?>>
                            <div class="ec-input-number-unit">個</div>
                        </div>
                        <div class="list-name">
                            <x-input-label for="order_qty" :value="__('数量')" />
                            <x-text-input class="block mt-1 w-full text-right" type="number" id="order-qty"
                                name="order_qty" :value="old('order_qty')" />
                            <x-input-label class="mt-auto" for="order_qty" :value="__('個')" />
                        </div>
                    </div>
                    <div>
                        @if ($product->qty == 0)
                            <div class="flex basis-full">
                                <x-primary-button class="w-full" name="update" :value="$ec_product->id">
                                    <i class="fa-solid fa-minus"></i>
                                </x-primary-button>
                            </div>
                        @else
                            <div class="flex basis-full">
                                <x-primary-button class="w-full" name="update" :value="$ec_product->id">
                                    <i class="fa-solid fa-cart-arrow-down fa-2xl" alt="カートに入れる"></i>
                                </x-primary-button>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endsection
