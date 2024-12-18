@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', 'ショッピングカート')

{{-- ページコンテンツ --}}
@section('content')
@if (empty($ecCartDetails))
<a class="flex basis-full my-2 p-2 rounded bg-sky-900 dark:bg-sky-100" href="@generateUrl('items')">
    <span class="mx-auto text-xl font-bold text-sky-50 dark:text-sky-950">商品一覧</span>
</a>
<div class="flex my-4 py-8">
    <p class="flex m-auto text-xl font-bold text-sky-950 dark:text-sky-50">ショッピングカートは空です。</p>
</div>
<a class="flex basis-full my-2 p-2 rounded bg-sky-900 dark:bg-sky-100" href="@generateUrl('items')">
    <span class="mx-auto text-xl font-bold text-sky-50 dark:text-sky-950">商品一覧</span>
</a>
@else
<div class="flex flex-row gap-2">
    <form class="flex basis-1/3 my-2 rounded bg-sky-900 dark:bg-sky-100" method="POST"
        action="@generateUrl('cart/clear')">
        @csrf
        <input type="hidden" name="cart_id" value="{{ Auth::user()->cart_id }}">
        <button class="w-full h-full p-2" type="submit" name="clear">
            <span class="text-center text-xl font-bold text-sky-50 dark:text-sky-950">空にする</span>
        </button>
    </form>
    <a class="flex basis-1/3 my-2 p-2 rounded bg-sky-900 dark:bg-sky-100" href="@generateUrl('items')">
        <span class="mx-auto text-xl font-bold text-sky-50 dark:text-sky-950">商品一覧</span>
    </a>
    <form class="flex basis-1/3 my-2 rounded bg-sky-900 dark:bg-sky-100" method="POST"
        action="@generateUrl('cart/checkout')">
        @csrf
        <input type="hidden" name="cart_id" value="{{ Auth::user()->cart_id }}">
        <button class="w-full h-full p-2" type="submit" name="checkout">
            <span class="text-center text-xl font-bold text-sky-50 dark:text-sky-950">購入する</span>
        </button>
    </form>
</div>
<div class="w-full pb-2">
    {{ $ecCartDetails->render() }}
</div>
<div class="w-full">
    @foreach ($ecCartDetails as $ecCartDetail)
    <div
        class="w-full p-4 flex flex-row basis-full gap-2 {{ $loop->first ? 'border-t-2' : '' }} border-b-2 border-sky-950 dark:border-sky-50 {{ $ecCartDetail->public_flg ? 'bg-sky-400 dark:bg-sky-700' : 'bg-sky-200 dark:bg-sky-900' }}">
        <form class="flex flex-col md:flex-row basis-full w-full gap-2 px-1" id="update-{{ $ecCartDetail->id }}"
            action="@generateUrl('cart/update')" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $ecCartDetail->id }}" />
            <input type="hidden" name="product_id" value="{{ $ecCartDetail->product_id }}" />
            <input type="hidden" name="stock" value="{{ $ecCartDetail->ec_products->qty }}" />
            <div class="flex flex-col grow-0 shrink-0 basis-88 md:basis-64 h-88 md:h-64 m-auto">
                <div
                    class="block w-88 md:w-64 h-88 md:h-64 border-solid border-2 border-sky-950 dark:border-sky-50  overflow-hidden">
                    <img class="block w-full h-hull object-cover" id="update-{{ $ecCartDetail->id }}-image-preview"
                        src="data:{{ $ecCartDetail->ec_products->image_type }};base64,{{ $ecCartDetail->ec_products->image_data }}">
                </div>
            </div>
            <div class="flex flex-col md:flex-row grow gap-2">
                <div class="flex flex-col basis-4/5 gap-1">
                    <div class="block">
                        <x-input-label for="update-{{ $ecCartDetail->id }}-name" :value="__('名称')" />
                        <x-text-input class="block mt-1 w-full" type="text" id="update-{{ $ecCartDetail->id }}-name"
                            name="name" :readonly="true" :value="$ecCartDetail->ec_products->name" />
                        @if (old('update') == $ecCartDetail->id)
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        @endif
                    </div>
                    <div class="block">
                        <x-input-label for="update-{{ $ecCartDetail->id }}-price" :value="__('価格')" />
                        <div class="flex flex-row content-stretch gap-2">
                            <x-text-input class="block mt-1 w-full text-right" type="number"
                                id="update-{{ $ecCartDetail->id }}-price" name="price" :readonly="true"
                                :value="$ecCartDetail->price" />
                            <x-input-label class="mt-auto" for="update-{{ $ecCartDetail->id }}-price"
                                :value="__('円')" />
                        </div>
                        @if (old('update') == $ecCartDetail->id)
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        @endif
                    </div>
                    <div class="block">
                        <x-input-label for="update-{{ $ecCartDetail->id }}-qty" :value="__('数量')" />
                        <div class="flex flex-row content-stretch gap-2">
                            <x-text-input class="block mt-1 w-full text-right" type="number"
                                id="update-{{ $ecCartDetail->id }}-qty" name="qty" :value="$ecCartDetail->qty" min="1"
                                max="{{ $ecCartDetail->ec_products->qty }}" required autofocus />
                            <x-input-label class="mt-auto" for="update-{{ $ecCartDetail->id }}-qty" :value="__('点')" />
                        </div>
                        @if (old('update') == $ecCartDetail->id)
                        <x-input-error :messages="$errors->get('qty')" class="mt-2" />
                        @endif
                    </div>
                    <div class="block">
                        <x-input-label for="update-{{ $ecCartDetail->id }}-sub-total" :value="__('小計')" />
                        <div class="flex flex-row content-stretch gap-2">
                            <x-text-input class="block mt-1 w-full text-right" type="number"
                                id="update-{{ $ecCartDetail->id }}-sub-total" name="sub-total" :disabled="true"
                                :value="$ecCartDetail->price * $ecCartDetail->qty" />
                            <x-input-label class="mt-auto" for="update-{{ $ecCartDetail->id }}-sub-total"
                                :value="__('円')" />
                        </div>
                        @if (old('update') == $ecCartDetail->id)
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        @endif
                    </div>
                </div>
                <div class="flex flex-row-reverse md:flex-col-reverse basis-1/5 gap-2">
                    <div class="flex basis-full">
                        <x-primary-button class="w-full" name="update" :value="$ecCartDetail->id">
                            <span class="flex m-auto text-lg md:text-xl text-center font-bold">{{ __('更新') }}</span>
                        </x-primary-button>
                    </div>
                    <div class="flex basis-full">
                        <x-secondary-button class="w-full" type="submit" name="delete" :value="$ecCartDetail->id"
                            formaction="@generateUrl('cart/delete')">
                            <span class="flex m-auto text-lg md:text-xl text-center font-bold">{{ __('削除') }}</span>
                        </x-secondary-button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @endforeach
</div>
<div class="w-full pt-2">
    {{ $ecCartDetails->render() }}
</div>
<div class="flex flex-row w-full py-4 border-t-2 border-b-2 border-sky-950 dark:border-sky-50">
    <div class="flex flex-row basis-1/5 justify-center">
        <span class="flex text-center font-bold text-2xl md:text-4xl text-sky-950 dark:text-sky-50">合計</span>
    </div>
    <div class="flex flex-row basis-2/5 items-end">
        <span
            class="w-4/5 text-right font-bold text-2xl md:text-4xl text-sky-950 dark:text-sky-50">{{ number_format($ecCartTotal->total_qty) }}</span>
        <span class="w-1/5 h-fit text-center text-xl md:text-2xl text-sky-900 dark:text-sky-100">点</span>
    </div>
    <div class="flex flex-row basis-2/5 items-end">
        <span
            class="w-4/5 text-right font-bold text-2xl md:text-4xl text-sky-950 dark:text-sky-50">{{ number_format($ecCartTotal->total_price) }}</span>
        <span class="w-1/5 h-fit text-center text-xl md:text-2xl text-sky-900 dark:text-sky-100">円</span>
    </div>
</div>
<div class="flex flex-row gap-2">
    <form class="flex basis-1/3 my-2 rounded bg-sky-900 dark:bg-sky-100" method="POST"
        action="@generateUrl('cart/clear')">
        @csrf
        <input type="hidden" name="cart_id" value="{{ Auth::user()->cart_id }}">
        <button class="w-full h-full p-2" type="submit" name="clear">
            <span class="text-center text-xl font-bold text-sky-50 dark:text-sky-950">空にする</span>
        </button>
    </form>
    <a class="flex basis-1/3 my-2 p-2 rounded bg-sky-900 dark:bg-sky-100" href="@generateUrl('items')">
        <span class="mx-auto text-xl font-bold text-sky-50 dark:text-sky-950">商品一覧</span>
    </a>
    <form class="flex basis-1/3 my-2 rounded bg-sky-900 dark:bg-sky-100" method="POST"
        action="@generateUrl('cart/checkout')">
        @csrf
        <input type="hidden" name="cart_id" value="{{ Auth::user()->cart_id }}">
        <button class="w-full h-full p-2" type="submit" name="checkout">
            <span class="text-center text-xl font-bold text-sky-50 dark:text-sky-950">購入する</span>
        </button>
    </form>
</div>
@endif
@endsection