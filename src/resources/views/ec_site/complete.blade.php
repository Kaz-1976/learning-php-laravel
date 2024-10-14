@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '決済完了')

{{-- ページコンテンツ --}}
@section('content')
<div class="flex flex-col">
    <div class="flex">
        <a class="flex basis-full my-2 p-4 rounded bg-sky-900 dark:bg-sky-100"
            href="{{ url('ec_site/items', null, app()->isProduction()) }}">
            <span class="mx-auto text-xl font-bold text-sky-50 dark:text-sky-950">商品一覧</span>
        </a>
    </div>
    @if (!empty($ec_cart_details))
    <div class="w-full py-2">
        {{ $ec_cart_details->render() }}
    </div>
    <div class="flex flex-col">
        @foreach ($ec_cart_details as $ec_cart_detail)
        <div
            class="flex flex-row basis-full gap-2 py-2 {{ $loop->first ? 'border-t-2' : '' }} border-b-2 border-sky-950 dark:border-sky-50 {{ $ec_cart_detail->public_flg ? 'bg-sky-400 dark:bg-sky-700' : 'bg-sky-200 dark:bg-sky-900' }}">
            <div class="flex flex-col md:flex-row basis-full w-full gap-2 px-1">
                <div class="flex flex-col grow-0 shrink-0 basis-88 md:basis-64 h-88 md:h-64 m-auto">
                    <div
                        class="block w-88 md:w-64 h-88 md:h-64 border-solid border-2 border-sky-950 dark:border-sky-50  overflow-hidden">
                        <img class="block w-full h-hull object-cover"
                            id="update-{{ $ec_cart_detail->id }}-image-preview"
                            src="data:{{ $ec_cart_detail->ec_products->image_type }};base64,{{ $ec_cart_detail->ec_products->image_data }}">
                    </div>
                </div>
                <div class="flex flex-col md:flex-row grow gap-2">
                    <div class="flex flex-col basis-full gap-1">
                        <div class="block">
                            <x-input-label for="update-{{ $ec_cart_detail->id }}-name" :value="__('名称')" />
                            <x-text-input class="block mt-1 w-full" type="text"
                                id="update-{{ $ec_cart_detail->id }}-name" :disabled="true"
                                :value="$ec_cart_detail->ec_products->name" />
                        </div>
                        <div class="block">
                            <x-input-label for="update-{{ $ec_cart_detail->id }}-price" :value="__('価格')" />
                            <div class="flex flex-row content-stretch gap-2">
                                <x-text-input class="block mt-1 w-full text-right" type="number"
                                    id="update-{{ $ec_cart_detail->id }}-price" :disabled="true"
                                    :value="$ec_cart_detail->price" />
                                <x-input-label class="mt-auto" for="update-{{ $ec_cart_detail->id }}-price"
                                    :value="__('円')" />
                            </div>
                        </div>
                        <div class="block">
                            <x-input-label for="update-{{ $ec_cart_detail->id }}-qty" :value="__('数量')" />
                            <div class="flex flex-row content-stretch gap-2">
                                <x-text-input class="block mt-1 w-full text-right" type="number"
                                    id="update-{{ $ec_cart_detail->id }}-qty" :value="$ec_cart_detail->qty"
                                    :disabled="true" />
                                <x-input-label class="mt-auto" for="update-{{ $ec_cart_detail->id }}-qty"
                                    :value="__('点')" />
                            </div>
                        </div>
                        <div class="block">
                            <x-input-label for="update-{{ $ec_cart_detail->id }}-sub-total" :value="__('小計')" />
                            <div class="flex flex-row content-stretch gap-2">
                                <x-text-input class="block mt-1 w-full text-right" type="number"
                                    id="update-{{ $ec_cart_detail->id }}-sub-total" :disabled="true"
                                    :value="$ec_cart_detail->price * $ec_cart_detail->qty" />
                                <x-input-label class="mt-auto" for="update-{{ $ec_cart_detail->id }}-sub-total"
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
        {{ $ec_cart_details->render() }}
    </div>
    <div class="flex flex-row w-full py-4 border-t-2 border-b-2 border-sky-950 dark:border-sky-50">
        <div class="flex flex-row basis-1/5 justify-center">
            <span class="flex text-center font-bold text-2xl md:text-4xl text-sky-950 dark:text-sky-50">合計</span>
        </div>
        <div class="flex flex-row basis-2/5 items-end">
            <span
                class="w-4/5 text-right font-bold text-2xl md:text-4xl text-sky-950 dark:text-sky-50">{{ number_format($ec_cart_total->total_qty) }}</span>
            <span class="w-1/5 h-fit text-center text-xl md:text-2xl text-sky-900 dark:text-sky-100">点</span>
        </div>
        <div class="flex flex-row basis-2/5 items-end">
            <span
                class="w-4/5 text-right font-bold text-2xl md:text-4xl text-sky-950 dark:text-sky-50">{{ number_format($ec_cart_total->total_price) }}</span>
            <span class="w-1/5 h-fit text-center text-xl md:text-2xl text-sky-900 dark:text-sky-100">円</span>
        </div>
    </div>
    @endif
    <div class="flex">
        <a class="flex basis-full my-2 p-4 rounded bg-sky-900 dark:bg-sky-100"
            href="{{ url('ec_site/items', null, app()->isProduction()) }}">
            <span class="mx-auto text-xl font-bold text-sky-50 dark:text-sky-950">商品一覧</span>
        </a>
    </div>
</div>
@endsection