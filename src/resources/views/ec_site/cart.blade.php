@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', 'ショッピングカート')

{{-- ページメニュー --}}
@section('menu')
    <x-link-button-box>
        @if (isEmpty($ecCartDetails))
            <x-link-button class="basis-full" link-type="link" link-to="{{ url('items', null, app()->isProduction()) }}">
                商品一覧
            </x-link-button>
        @else
            <x-link-button class="basis-1/3" link-type="form" link-to="{{ url('cart/clear', null, app()->isProduction()) }}">
                空にする
            </x-link-button>
            <x-link-button class="basis-1/3" link-type="link" link-to="{{ url('items', null, app()->isProduction()) }}">
                商品一覧
            </x-link-button>
            <x-link-button class="basis-1/3" link-type="link" link-to="{{ url('shipping', null, app()->isProduction()) }}">
                購入する
            </x-link-button>
        @endif
    </x-link-button-box>
@endsection

{{-- ページコンテンツ --}}
@section('content')
    @if (isEmpty($ecCartDetails))
        {{-- 本体 --}}
        <x-empty-string-box>ショッピングカートは空です。</x-empty-string-box>
    @else
        {{-- 本体 --}}
        <div class="w-full py-2">
            {{ $ecCartDetails->render() }}
        </div>
        <div class="w-full">
            @foreach ($ecCartDetails as $ecCartDetail)
                <div
                    class="{{ $loop->first ? 'border-t-2' : '' }} {{ $ecCartDetail->public_flg ? 'bg-sky-400 dark:bg-sky-700' : 'bg-sky-200 dark:bg-sky-900' }} flex w-full basis-full flex-row gap-2 border-b-2 border-sky-950 p-4 dark:border-sky-50">
                    <form class="flex w-full basis-full flex-col gap-2 px-1 md:flex-row" id="update-{{ $ecCartDetail->id }}"
                        action="{{ url('cart/update', null, app()->isProduction()) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input name="id" type="hidden" value="{{ $ecCartDetail->id }}" />
                        <input name="product_id" type="hidden" value="{{ $ecCartDetail->product_id }}" />
                        <input name="stock" type="hidden" value="{{ $ecCartDetail->ec_products->qty }}" />
                        <x-image-box class="w-88 h-88 basis-88 md:h-64 md:w-64 md:basis-64" :border="false"
                            image-id="update-{{ $ecCartDetail->id }}-image-preview"
                            image-url="{{ url('api/product-image/' . $ecCartDetail->ec_products->id, null, app()->isProduction()) }}"
                            image-alt="{{ $ecCartDetail->ec_products->name }}"
                            image-title="{{ $ecCartDetail->ec_products->name }}">
                        </x-image-box>
                        <div class="flex grow flex-col gap-2 md:flex-row">
                            <div class="flex basis-4/5 flex-col gap-1">
                                <div class="block">
                                    <x-input-label for="update-{{ $ecCartDetail->id }}-name" :value="__('名称')" />
                                    <x-text-input class="mt-1 block w-full" id="update-{{ $ecCartDetail->id }}-name"
                                        name="name" type="text" :readonly="true" :value="$ecCartDetail->ec_products->name" />
                                    @if (old('update') == $ecCartDetail->id)
                                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                    @endif
                                </div>
                                <div class="block">
                                    <x-input-label for="update-{{ $ecCartDetail->id }}-price" :value="__('価格')" />
                                    <div class="flex flex-row content-stretch gap-2">
                                        <x-text-input class="mt-1 block w-full text-right"
                                            id="update-{{ $ecCartDetail->id }}-price" name="price" type="number"
                                            :readonly="true" :value="$ecCartDetail->price" />
                                        <x-input-label class="mt-auto" for="update-{{ $ecCartDetail->id }}-price"
                                            :value="__('円')" />
                                    </div>
                                    @if (old('update') == $ecCartDetail->id)
                                        <x-input-error class="mt-2" :messages="$errors->get('price')" />
                                    @endif
                                </div>
                                <div class="block">
                                    <x-input-label for="update-{{ $ecCartDetail->id }}-qty" :value="__('数量')" />
                                    <div class="flex flex-row content-stretch gap-2">
                                        <x-text-input class="mt-1 block w-full text-right"
                                            id="update-{{ $ecCartDetail->id }}-qty" name="qty" type="number"
                                            :value="$ecCartDetail->qty" min="1" max="{{ $ecCartDetail->ec_products->qty }}"
                                            required autofocus />
                                        <x-input-label class="mt-auto" for="update-{{ $ecCartDetail->id }}-qty"
                                            :value="__('点')" />
                                    </div>
                                    @if (old('update') == $ecCartDetail->id)
                                        <x-input-error class="mt-2" :messages="$errors->get('qty')" />
                                    @endif
                                </div>
                                <div class="block">
                                    <x-input-label for="update-{{ $ecCartDetail->id }}-sub-total" :value="__('小計')" />
                                    <div class="flex flex-row content-stretch gap-2">
                                        <x-text-input class="mt-1 block w-full text-right"
                                            id="update-{{ $ecCartDetail->id }}-sub-total" name="sub-total" type="number"
                                            :disabled="true" :value="$ecCartDetail->price * $ecCartDetail->qty" />
                                        <x-input-label class="mt-auto" for="update-{{ $ecCartDetail->id }}-sub-total"
                                            :value="__('円')" />
                                    </div>
                                    @if (old('update') == $ecCartDetail->id)
                                        <x-input-error class="mt-2" :messages="$errors->get('price')" />
                                    @endif
                                </div>
                            </div>
                            <div class="flex basis-1/5 flex-row-reverse gap-2 md:flex-col-reverse">
                                <div class="flex basis-full">
                                    <x-primary-button class="w-full" name="update" :value="$ecCartDetail->id">
                                        <span
                                            class="m-auto flex text-center text-lg font-bold md:text-xl">{{ __('更新') }}</span>
                                    </x-primary-button>
                                </div>
                                <div class="flex basis-full">
                                    <x-secondary-button class="w-full" name="delete"
                                        formaction="{{ url('cart/delete', null, app()->isProduction()) }}" type="submit"
                                        :value="$ecCartDetail->id">
                                        <span
                                            class="m-auto flex text-center text-lg font-bold md:text-xl">{{ __('削除') }}</span>
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
    @endif
@endsection
