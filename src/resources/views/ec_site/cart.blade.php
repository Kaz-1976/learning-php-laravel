@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', 'ショッピングカート')

{{-- ページコンテンツ --}}
@section('content')
    @if (empty($ecCartDetails))
        {{-- ヘッダー --}}
        <x-link-button-box>
            <x-link-button class="basis-full" link-type="link" link-to="/items">商品一覧</x-link-button>
        </x-link-button-box>
        {{-- 本体 --}}
        <x-empty-string-box>ショッピングカートは空です。</x-empty-string-box>
        {{-- フッター --}}
        <x-link-button-box>
            <x-link-button class="basis-full" link-type="link" link-to="/items">商品一覧</x-link-button>
        </x-link-button-box>
    @else
        {{-- ヘッダー --}}
        <x-link-button-box>
            <x-link-button class="basis-1/3" link-type="form"
                link-to="{{ url('cart/clear', null, app()->isProduction()) }}">空にする</x-link-button>
            <x-link-button class="basis-1/3" link-type="link"
                link-to="{{ url('items', null, app()->isProduction()) }}">商品一覧</x-link-button>
            <x-link-button class="basis-1/3" link-type="link"
                link-to="{{ url('shipping', null, app()->isProduction()) }}">購入する</x-link-button>
        </x-link-button-box>
        {{-- 本体 --}}
        <div class="w-full py-2">
            {{ $ecCartDetails->render() }}
        </div>
        <div class="w-full">
            @foreach ($ecCartDetails as $ecCartDetail)
                <div
                    class="w-full p-4 flex flex-row basis-full gap-2 {{ $loop->first ? 'border-t-2' : '' }} border-b-2 border-sky-950 dark:border-sky-50 {{ $ecCartDetail->public_flg ? 'bg-sky-400 dark:bg-sky-700' : 'bg-sky-200 dark:bg-sky-900' }}">
                    <form class="flex flex-col md:flex-row basis-full w-full gap-2 px-1" id="update-{{ $ecCartDetail->id }}"
                        action="{{ url('cart/update', null, app()->isProduction()) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $ecCartDetail->id }}" />
                        <input type="hidden" name="product_id" value="{{ $ecCartDetail->product_id }}" />
                        <input type="hidden" name="stock" value="{{ $ecCartDetail->ec_products->qty }}" />
                        <x-image-box class="w-88 md:w-64 h-88 md:h-64 basis-88 md:basis-64" :border="false"
                            image-id="update-{{ $ecCartDetail->id }}-image-preview"
                            image-url="{{ url('api/product-image/' . $ecCartDetail->ec_products->id, null, app()->isProduction()) }}"
                            image-alt="{{ $ecCartDetail->ec_products->name }}"
                            image-title="{{ $ecCartDetail->ec_products->name }}">
                        </x-image-box>
                        <div class="flex flex-col md:flex-row grow gap-2">
                            <div class="flex flex-col basis-4/5 gap-1">
                                <div class="block">
                                    <x-input-label for="update-{{ $ecCartDetail->id }}-name" :value="__('名称')" />
                                    <x-text-input class="block mt-1 w-full" type="text"
                                        id="update-{{ $ecCartDetail->id }}-name" name="name" :readonly="true"
                                        :value="$ecCartDetail->ec_products->name" />
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
                                            id="update-{{ $ecCartDetail->id }}-qty" name="qty" :value="$ecCartDetail->qty"
                                            min="1" max="{{ $ecCartDetail->ec_products->qty }}" required
                                            autofocus />
                                        <x-input-label class="mt-auto" for="update-{{ $ecCartDetail->id }}-qty"
                                            :value="__('点')" />
                                    </div>
                                    @if (old('update') == $ecCartDetail->id)
                                        <x-input-error :messages="$errors->get('qty')" class="mt-2" />
                                    @endif
                                </div>
                                <div class="block">
                                    <x-input-label for="update-{{ $ecCartDetail->id }}-sub-total" :value="__('小計')" />
                                    <div class="flex flex-row content-stretch gap-2">
                                        <x-text-input class="block mt-1 w-full text-right" type="number"
                                            id="update-{{ $ecCartDetail->id }}-sub-total" name="sub-total"
                                            :disabled="true" :value="$ecCartDetail->price * $ecCartDetail->qty" />
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
                                        <span
                                            class="flex m-auto text-lg md:text-xl text-center font-bold">{{ __('更新') }}</span>
                                    </x-primary-button>
                                </div>
                                <div class="flex basis-full">
                                    <x-secondary-button class="w-full" type="submit" name="delete" :value="$ecCartDetail->id"
                                        formaction="{{ url('cart/delete', null, app()->isProduction()) }}">
                                        <span
                                            class="flex m-auto text-lg md:text-xl text-center font-bold">{{ __('削除') }}</span>
                                    </x-secondary-button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
        <div class="w-full py-2">
            {{ $ecCartDetails->render() }}
        </div>
        {{-- トータル --}}
        <x-total-display :total-qty="$ecCartTotal->total_qty" :total-amount="$ecCartTotal->total_amount"></x-total-display>
        {{-- フッター --}}
        <x-link-button-box>
            <x-link-button class="basis-1/3" link-type="form"
                link-to="{{ url('cart/clear', null, app()->isProduction()) }}">空にする</x-link-button>
            <x-link-button class="basis-1/3" link-type="link"
                link-to="{{ url('items', null, app()->isProduction()) }}">商品一覧</x-link-button>
            <x-link-button class="basis-1/3" link-type="link"
                link-to="{{ url('shipping', null, app()->isProduction()) }}">購入する</x-link-button>
        </x-link-button-box>
    @endif
@endsection
