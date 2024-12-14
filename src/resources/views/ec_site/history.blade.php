@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '購入履歴')

{{-- ページコンテンツ --}}
@section('content')
@if (empty($ec_carts))

@else
<div class="w-full pb-2">
    {{ $ec_carts->render() }}
</div>
<div class="flex flex-col">
    @foreach ($ec_carts as $ec_cart)
    <div
        class="flex flex-row basis-full gap-2 py-2 {{ $loop->first ? 'border-t-2' : '' }} border-b-2 border-sky-950 dark:border-sky-50 {{ $ec_cart->public_flg ? 'bg-sky-400 dark:bg-sky-700' : 'bg-sky-200 dark:bg-sky-900' }}">
        <div class="flex flex-col md:flex-row basis-full w-full gap-2 px-1">
            <div class="flex flex-col grow-0 shrink-0 basis-88 md:basis-64 h-88 md:h-64 m-auto">
                <div
                    class="block w-88 md:w-64 h-88 md:h-64 border-solid border-2 border-sky-950 dark:border-sky-50  overflow-hidden">
                    <img class="block w-full h-hull object-cover" id="update-{{ $ec_cart->id }}-image-preview"
                        src="data:{{ $ec_cart->ec_products->image_type }};base64,{{ $ec_cart->ec_products->image_data }}">
                </div>
            </div>
            <div class="flex flex-col md:flex-row grow gap-2">
                <div class="flex flex-col basis-full gap-1">
                    <div class="block">
                        <x-input-label for="update-{{ $ec_cart->id }}-name" :value="__('名称')" />
                        <x-text-input class="block mt-1 w-full" type="text" id="update-{{ $ec_cart->id }}-name"
                            :disabled="true" :value="$ec_cart->ec_products->name" />
                    </div>
                    <div class="block">
                        <x-input-label for="update-{{ $ec_cart->id }}-price" :value="__('価格')" />
                        <div class="flex flex-row content-stretch gap-2">
                            <x-text-input class="block mt-1 w-full text-right" type="number"
                                id="update-{{ $ec_cart->id }}-price" :disabled="true" :value="$ec_cart->price" />
                            <x-input-label class="mt-auto" for="update-{{ $ec_cart->id }}-price" :value="__('円')" />
                        </div>
                    </div>
                    <div class="block">
                        <x-input-label for="update-{{ $ec_cart->id }}-qty" :value="__('数量')" />
                        <div class="flex flex-row content-stretch gap-2">
                            <x-text-input class="block mt-1 w-full text-right" type="number"
                                id="update-{{ $ec_cart->id }}-qty" :value="$ec_cart->qty" :disabled="true" />
                            <x-input-label class="mt-auto" for="update-{{ $ec_cart->id }}-qty" :value="__('点')" />
                        </div>
                    </div>
                    <div class="block">
                        <x-input-label for="update-{{ $ec_cart->id }}-sub-total" :value="__('小計')" />
                        <div class="flex flex-row content-stretch gap-2">
                            <x-text-input class="block mt-1 w-full text-right" type="number"
                                id="update-{{ $ec_cart->id }}-sub-total" :disabled="true"
                                :value="$ec_cart->price * $ec_cart->qty" />
                            <x-input-label class="mt-auto" for="update-{{ $ec_cart->id }}-sub-total" :value="__('円')" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="w-full pt-2">
    {{ $ec_carts->render() }}
</div>
@endif
@endsection