@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', 'ショッピングカート')

{{-- ページコンテンツ --}}
@section('content')
    @if (empty($ec_cart_data))
        <div>
            <div class="flex my-2 p-4 rounded bg-sky-900 dark:bg-sky-100">
                <a class="m-auto" href="{{ route('items.index') }}">
                    <span class="text-xl font-bold text-sky-50 dark:text-sky-950">商品一覧</span>
                </a>
            </div>
            <div class="flex my-4 p-4">
                <p class="flex m-auto text-xl font-bold text-sky-950 dark:text-sky-50">ショッピングカートは空です。</p>
            </div>
            <div class="flex my-2 p-4 rounded bg-sky-900 dark:bg-sky-100">
                <a class="m-auto" href="{{ route('items.index') }}">
                    <span class="text-xl font-bold text-sky-50 dark:text-sky-950">商品一覧</span>
                </a>
            </div>
        </div>
    @else
        <div>
            <div class="flex flex-row gap-2">
                <div class="flex basis-1/3 my-2 p-4 rounded bg-sky-900 dark:bg-sky-100">
                    <form class="m-auto" method="POST" action="{{ route('cart.clear') }}">
                        @csrf
                        <input type="hidden" name="cart_id" value="{{ Auth::user()->cart_id }}">
                        <button type="submit" name="clear">
                            <span class="text-center text-xl font-bold text-sky-50 dark:text-sky-950">空にする</span>
                        </button>
                    </form>
                </div>
                <div class="flex basis-1/3 my-2 p-4 rounded bg-sky-900 dark:bg-sky-100">
                    <a class="m-auto text-center" href="{{ route('items.index') }}">
                        <span class="text-xl font-bold text-sky-50 dark:text-sky-950">商品一覧</span>
                    </a>
                </div>
                <div class="flex basis-1/3 my-2 p-4 rounded bg-sky-900 dark:bg-sky-100">
                    <form class="m-auto" method="POST" action="{{ route('cart.checkout') }}">
                        @csrf
                        <input type="hidden" name="cart_id" value="{{ Auth::user()->cart_id }}">
                        <button type="submit" name="checkout">
                            <span class="text-center text-xl font-bold text-sky-50 dark:text-sky-950">購入する</span>
                        </button>
                    </form>
                </div>
            </div>
            <div class="w-full py-2">
                {{ $ec_cart_data->render() }}
            </div>
            <div class="w-full">
                @foreach ($ec_cart_data->ec_cart_details as $ec_cart_detail)
                    <div
                        class="w-full p-4 flex flex-row basis-full gap-2 {{ $loop->first ? 'border-t-2' : '' }} border-b-2 border-sky-950 dark:border-sky-50 {{ $ec_cart_detail->public_flg ? 'bg-sky-400 dark:bg-sky-700' : 'bg-sky-200 dark:bg-sky-900' }}">
                        <form class="flex flex-col md:flex-row basis-full w-full gap-2"
                            id="update-{{ $ec_cart_detail->id }}" action="{{ route('cart.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $ec_cart_detail->id }}" />
                            <input type="hidden" name="product_id" value="{{ $ec_cart_detail->product_id }}" />
                            <input type="hidden" name="stock" value="{{ $ec_cart_detail->ec_products->qty }}" />
                            <input type="hidden" name="price" value="{{ $ec_cart_detail->ec_products->price }}" />
                            <div class="flex flex-col grow-0 shrink-0 basis-88 md:basis-64 h-88 md:h-64 m-auto">
                                <div
                                    class="block w-88 md:w-64 h-88 md:h-64 border-solid border-2 border-sky-950 dark:border-sky-50  overflow-hidden">
                                    <img class="block w-full h-hull object-cover"
                                        id="update-{{ $ec_cart_detail->id }}-image-preview"
                                        src="data:{{ $ec_cart_detail->ec_products->image_type }};base64,{{ $ec_cart_detail->ec_products->image_data }}">
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row grow gap-2">
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
                                                :value="__('点')" />
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
                                <div class="flex flex-row md:flex-col basis-1/5 gap-2">
                                    <div class="flex basis-full">
                                        <x-secondary-button class="w-full" type="submit" name="delete"
                                            :value="$ec_cart_detail->id" formaction="{{ route('cart.delete') }}">
                                            <span
                                                class="flex m-auto text-lg md:text-xl text-center font-bold">{{ __('削除') }}</span>
                                        </x-secondary-button>
                                    </div>
                                    <div class="flex basis-full">
                                        <x-primary-button class="w-full" name="update" :value="$ec_cart_detail->id">
                                            <span
                                                class="flex m-auto text-lg md:text-xl text-center font-bold">{{ __('更新') }}</span>
                                        </x-primary-button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
            <div class="w-full py-2">
                {{ $ec_cart_data->render() }}
            </div>
            <div class="flex flex-row w-full py-4 border-t-2 border-b-2 border-sky-950 dark:border-sky-50">
                <div class="flex flex-row basis-1/5 justify-center">
                    <span class="flex text-center font-bold text-2xl md:text-4xl text-sky-950 dark:text-sky-50">合計</span>
                </div>
                <div class="flex flex-row basis-2/5 items-end">
                    <span
                        class="w-4/5 text-right font-bold text-2xl md:text-4xl text-sky-950 dark:text-sky-50">{{ number_format($ec_cart_total[0]->total_qty) }}</span>
                    <span class="w-1/5 h-fit text-center text-xl md:text-2xl text-sky-900 dark:text-sky-100">点</span>
                </div>
                <div class="flex flex-row basis-2/5 items-end">
                    <span
                        class="w-4/5 text-right font-bold text-2xl md:text-4xl text-sky-950 dark:text-sky-50">{{ number_format($ec_cart_total[0]->total_price) }}</span>
                    <span class="w-1/5 h-fit text-center text-xl md:text-2xl text-sky-900 dark:text-sky-100">円</span>
                </div>
            </div>
            <div class="flex flex-row gap-2">
                <div class="flex basis-1/3 my-2 p-4 rounded bg-sky-900 dark:bg-sky-100">
                    <form class="m-auto" method="POST" action="{{ route('cart.clear') }}">
                        @csrf
                        <input type="hidden" name="cart_id" value="{{ Auth::user()->cart_id }}">
                        <button type="submit" name="clear">
                            <span class="text-center text-xl font-bold text-sky-50 dark:text-sky-950">空にする</span>
                        </button>
                    </form>
                </div>
                <div class="flex basis-1/3 my-2 p-4 rounded bg-sky-900 dark:bg-sky-100">
                    <a class="m-auto text-center" href="{{ route('items.index') }}">
                        <span class="text-xl font-bold text-sky-50 dark:text-sky-950">商品一覧</span>
                    </a>
                </div>
                <div class="flex basis-1/3 my-2 p-4 rounded bg-sky-900 dark:bg-sky-100">
                    <form class="m-auto" method="POST" action="{{ route('cart.checkout') }}">
                        @csrf
                        <input type="hidden" name="cart_id" value="{{ Auth::user()->cart_id }}">
                        <button type="submit" name="checkout">
                            <span class="text-center text-xl font-bold text-sky-50 dark:text-sky-950">購入する</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
