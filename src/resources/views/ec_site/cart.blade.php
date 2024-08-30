@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', 'ショッピングカート')

{{-- ページコンテンツ --}}
@section('content')
    @if (empty($ec_cart_details))
        <div>
            <div class="">
                <a class="" href="">
                    <span class="">商品一覧</span>
                </a>
            </div>
            <div class="flex ">
                <p class="">ショッピングカートは空です。</p>
            </div>
            <div class="">
                <a class="" href="">
                    <span class="">商品一覧</span>
                </a>
            </div>
        </div>
    @else
        <div>
            <div class="container w-full pb-1">
                {{ $ec_cart_details->render() }}
            </div>
            <div class="container">
                @foreach ($ec_cart_details as $ec_cart_detail)
                    <div
                        class="w-full p-4 flex flex-row basis-full gap-2 {{ $loop->first ? 'border-t-2' : '' }} border-b-2 border-sky-950 dark:border-sky-50 {{ $ec_cart_detail->public_flg ? 'bg-sky-400 dark:bg-sky-700' : 'bg-sky-200 dark:bg-sky-900' }}">
                        <form class="flex flex-row basis-full gap-2" id="update-{{ $ec_cart_detail->id }}"
                            action="{{ route('cart.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $ec_cart_detail->id }}" />
                            <div class="flex flex-col grow-0 basis-64 h-64 m-auto">
                                <div class="block w-64 h-64 border-solid border-2 border-sky-50">
                                    <img class="block w-full h-hull object-cover overflow-hidden"
                                        id="update-{{ $ec_cart_detail->id }}-image-preview"
                                        src="data:{{ $ec_cart_detail->ec_products->image_type }};base64,{{ $ec_cart_detail->ec_products->image_data }}">
                                </div>
                            </div>
                            <div class="flex flex-row grow gap-2">
                                <div class="flex flex-col basis-4/5 gap-1">
                                    <div class="block">
                                        <x-input-label for="update-{{ $ec_cart_detail->id }}-name" :value="__('名称')" />
                                        <x-text-input class="block mt-1 w-full" type="text"
                                            id="update-{{ $ec_cart_detail->id }}-name" name="name" :disabled="true"
                                            :value="$ec_cart_detail->ec_products->name" />
                                        @if (old('update') == $ec_cart_detail->id)
                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                        @endif
                                    </div>
                                    <div class="block">
                                        <x-input-label for="update-{{ $ec_cart_detail->id }}-price" :value="__('価格')" />
                                        <div class="flex flex-row content-stretch gap-2">
                                            <x-text-input class="block mt-1 w-full text-right" type="number"
                                                id="update-{{ $ec_cart_detail->id }}-price" name="price"
                                                :disabled="true" :value="$ec_cart_detail->price" />
                                            <x-input-label class="mt-auto" for="update-{{ $ec_cart_detail->id }}-price"
                                                :value="__('円')" />
                                        </div>
                                        @if (old('update') == $ec_cart_detail->id)
                                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                        @endif
                                    </div>
                                    <div class="block">
                                        <x-input-label for="update-{{ $ec_cart_detail->id }}-qty" :value="__('数量')" />
                                        <div class="flex flex-row content-stretch gap-2">
                                            <x-text-input class="block mt-1 w-full text-right" type="number"
                                                id="update-{{ $ec_cart_detail->id }}-qty" name="qty" :value="$ec_cart_detail->qty"
                                                required autofocus />
                                            <x-input-label class="mt-auto" for="update-{{ $ec_cart_detail->id }}-qty"
                                                :value="__('個')" />
                                        </div>
                                        @if (old('update') == $ec_cart_detail->id)
                                            <x-input-error :messages="$errors->get('qty')" class="mt-2" />
                                        @endif
                                    </div>
                                    <div class="block">
                                        <x-input-label for="update-{{ $ec_cart_detail->id }}-sub-total"
                                            :value="__('小計')" />
                                        <div class="flex flex-row content-stretch gap-2">
                                            <x-text-input class="block mt-1 w-full text-right" type="number"
                                                id="update-{{ $ec_cart_detail->id }}-sub-total" name="sub-total"
                                                :disabled="true" :value="$ec_cart_detail->price * $ec_cart_detail->qty" />
                                            <x-input-label class="mt-auto" for="update-{{ $ec_cart_detail->id }}-sub-total"
                                                :value="__('円')" />
                                        </div>
                                        @if (old('update') == $ec_cart_detail->id)
                                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                        @endif
                                    </div>
                                </div>
                                <div class="flex flex-col basis-1/5 gap-2">
                                    <div class="flex basis-full">
                                        <x-secondary-button class="w-full" type="submit" name="update">
                                            <span
                                                class="flex m-auto text-xl text-center font-bold">{{ __('削除') }}</span>
                                        </x-secondary-button>
                                    </div>
                                    <div class="flex basis-full">
                                        <x-primary-button class="w-full" name="update" :value="$ec_cart_detail->id">
                                            <span
                                                class="flex m-auto text-xl text-center font-bold">{{ __('更新') }}</span>
                                        </x-primary-button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
            <div class="container w-full pt-1">
                {{ $ec_cart_details->render() }}
            </div>
        </div>
    @endif
@endsection
