@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '商品管理')

{{-- ページメニュー --}}
@section('menu')
    <x-link-button-box>
        <x-link-button class="basis-full" link-type="link" link-to="{{ url('admin', null, app()->isProduction()) }}">
            管理メニュー
        </x-link-button>
    </x-link-button-box>
@endsection

{{-- ページコンテンツ --}}
@section('content')
    <div class="flex flex-col gap-2">
        <form id="register" action="{{ url('admin/products/store', null, app()->isProduction()) }}" method="POST"
            enctype="multipart/form-data">
            {{-- CSRF対策 --}}
            @csrf
            {{-- 登録カード --}}
            <x-register-card>
                <x-card-box class="basis-full" :direction="'col'" :responsive="true">
                    {{-- 画像ボックス --}}
                    <x-card-box class="m-auto w-64 grow-0 basis-64 md:w-80 md:basis-80">
                        <x-image-box class="h-64 w-64 basis-64 md:h-80 md:w-80 md:basis-80"
                            image-id="register-image-preview" />
                    </x-card-box>
                    {{-- 入力ボックス --}}
                    <x-card-box class="basis-full" :direction="'col'">
                        <x-card-box class="basis-full" :direction="'col'">
                            {{-- 商品名 --}}
                            <x-card-item>
                                <x-input-label for="register-product-name" :value="__('商品名')" />
                                <x-text-input class="mt-1 block w-full" id="register-product-name" name="name"
                                    type="text" :value="old('name')" required autofocus />
                                @if (old('register') == '1')
                                    <x-input-error class="my-2" :messages="$errors->get('name')" />
                                @endif
                            </x-card-item>
                            {{-- 数量 --}}
                            <x-card-item>
                                <x-input-label for="register-qty" :value="__('数量')" />
                                <div class="flex flex-row content-stretch gap-2">
                                    <x-text-input class="mt-1 w-full basis-auto text-right" id="register-qty" name="qty"
                                        type="number" :value="old('qty')" required autofocus />
                                    <x-input-label class="mt-auto" for="register-qty" :value="__('点')" />
                                </div>
                                @if (old('register') == '1')
                                    <x-input-error class="my-2" :messages="$errors->get('qty')" />
                                @endif
                            </x-card-item>
                            {{-- 価格 --}}
                            <x-card-item>
                                <x-input-label for="register-price" :value="__('価格')" />
                                <div class="flex flex-row content-stretch gap-2">
                                    <x-text-input class="mt-1 block w-full text-right" id="register-price" name="price"
                                        type="number" :value="old('price')" required autofocus />
                                    <x-input-label class="mt-auto" for="register-qty" :value="__('円')" />
                                </div>
                                @if (old('register') == '1')
                                    <x-input-error class="my-2" :messages="$errors->get('price')" />
                                @endif
                            </x-card-item>
                            {{-- 画像 --}}
                            <x-card-item>
                                <x-input-label for="register-image" :value="__('画像')" />
                                <x-text-input class="mt-1 block w-full" id="register-image" name="image" type="file"
                                    required accept="image/*" />
                                @if (old('register') == '1')
                                    <x-input-error class="my-2" :messages="$errors->get('image')" />
                                @endif
                            </x-card-item>
                        </x-card-box>
                        {{-- 操作ボックス --}}
                        <x-card-box :direction="'row'">
                            {{-- チェック --}}
                            <x-card-item class="md:1/5 my-auto flex basis-1/3" :direction="'row'">
                                <x-text-input class="h-8 w-8" id="register-public" name="public_flg" type="checkbox"
                                    :value="old('public_flg')" autofocus />
                                <x-input-label class="text-md my-auto flex pl-2" for="register-public" :value="__('公開')" />
                            </x-card-item>
                            {{-- ボタン --}}
                            <x-card-box class="basis-4/5 md:basis-2/3" :direction="'row-reverse'">
                                <x-card-item class="my-auto flex basis-1/2" :direction="'row'">
                                    <x-primary-button class="flex basis-full" name="register" :value="1">
                                        <span
                                            class="md:text-md m-auto flex text-center text-xs font-bold">{{ __('Register') }}</span>
                                    </x-primary-button>
                                </x-card-item>
                                <x-card-item class="my-auto flex basis-1/2" :direction="'row'">
                                    <x-secondary-button class="flex basis-full" name="reset" type='reset'
                                        :value="1">
                                        <span
                                            class="md:text-md m-auto flex text-center text-xs font-bold">{{ __('リセット') }}</span>
                                    </x-secondary-button>
                                </x-card-item>
                            </x-card-box>
                        </x-card-box>
                    </x-card-box>
                </x-card-box>
            </x-register-card>
        </form>
        @if ($ecProducts->isEmpty())
            <x-empty-string-box>商品が登録されていません。</x-empty-string-box>
        @else
            <div class="w-full">
                {{ $ecProducts->render() }}
            </div>
            <div class="w-full">
                @foreach ($ecProducts as $ecProduct)
                    <form id="update-{{ $ecProduct->id }}"
                        action="{{ url('admin/products/update', null, app()->isProduction()) }}" method="POST"
                        enctype="multipart/form-data">
                        {{-- CSRF対策 --}}
                        @csrf
                        {{-- 隠し項目 --}}
                        <input name="id" type="hidden" value="{{ $ecProduct->id }}" />
                        <input name="public_flg" type="hidden" value="{{ $ecProduct->public_flg }}" />
                        {{-- 更新カード --}}
                        <x-update-card :loop="$loop->first" :flag="$ecProduct->public_flg">
                            <x-card-box class="m-auto h-64 w-64">
                                <x-image-box class="h-64 w-64" image-id="update-{{ $ecProduct->id }}-image-preview"
                                    image-url="{{ url('api/product-image/' . $ecProduct->id, null, app()->isProduction()) }}"
                                    image-alt="{{ $ecProduct->name }}" image-title="{{ $ecProduct->name }}" />
                            </x-card-box>
                            <x-card-box class="basis-full" :direction="'col'" :responsive="true">
                                <x-card-box class="basis-full md:basis-3/4" :direction="'col'">
                                    <x-card-item>
                                        <x-input-label for="update-{{ $ecProduct->id }}-name" :value="__('名称')" />
                                        <x-text-input class="mt-1 block w-full" id="update-{{ $ecProduct->id }}-name"
                                            name="name" type="text" :value="$ecProduct->name" required autofocus
                                            autocomplete="name" />
                                        @if (old('update') == $ecProduct->id)
                                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                        @endif
                                    </x-card-item>
                                    <x-card-item>
                                        <x-input-label for="update-{{ $ecProduct->id }}-qty" :value="__('数量')" />
                                        <div class="flex flex-row content-stretch gap-2">
                                            <x-text-input class="mt-1 block w-full text-right"
                                                id="update-{{ $ecProduct->id }}-qty" name="qty" type="number"
                                                :value="$ecProduct->qty" required autofocus />
                                            <x-input-label class="mt-auto" for="update-{{ $ecProduct->id }}-qty"
                                                :value="__('点')" />
                                        </div>
                                        @if (old('update') == $ecProduct->id)
                                            <x-input-error class="mt-2" :messages="$errors->get('qty')" />
                                        @endif
                                    </x-card-item>
                                    <x-card-item>
                                        <x-input-label for="update-{{ $ecProduct->id }}-price" :value="__('価格')" />
                                        <div class="flex flex-row content-stretch gap-2">
                                            <x-text-input class="mt-1 block w-full text-right"
                                                id="update-{{ $ecProduct->id }}-price" name="price" type="number"
                                                :value="$ecProduct->price" required autofocus />
                                            <x-input-label class="mt-auto" for="update-{{ $ecProduct->id }}-price"
                                                :value="__('円')" />
                                        </div>
                                        @if (old('update') == $ecProduct->id)
                                            <x-input-error class="mt-2" :messages="$errors->get('price')" />
                                        @endif
                                    </x-card-item>
                                    <x-card-item>
                                        <x-input-label for="update-{{ $ecProduct->id }}-image" :value="__('画像')" />
                                        <x-text-input class="mt-1 block w-full" id="update-{{ $ecProduct->id }}-image"
                                            name="image" type="file" accept="image/*" />
                                        @if (old('update') == $ecProduct->id)
                                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                                        @endif
                                    </x-card-item>
                                </x-card-box>
                                <x-card-box class="basis-full md:basis-1/4" :direction="'row-reverse'" :responsive="true">
                                    <x-card-item class="flex basis-1/3">
                                        <x-primary-button class="flex basis-full"
                                            id="update-{{ $ecProduct->id }}-btn-submit" name="update"
                                            form="update-{{ $ecProduct->id }}" :value="$ecProduct->id">
                                            <span
                                                class="md:text-md m-auto flex text-center text-xs font-bold">{{ __('更新') }}</span>
                                        </x-primary-button>
                                    </x-card-item>
                                    <x-card-item class="flex basis-1/3">
                                        <x-secondary-button class="flex basis-full"
                                            id="update-{{ $ecProduct->id }}-btn-reset" name="reset" type="reset">
                                            <span
                                                class="md:text-md m-auto flex text-center text-xs font-bold">{{ __('リセット') }}</span>
                                        </x-secondary-button>
                                    </x-card-item>
                                    <x-card-item class="flex basis-1/3">
                                        <x-secondary-button class="flex basis-full"
                                            id="update-{{ $ecProduct->id }}-btn-public" name="public" type="submit"
                                            :value="$ecProduct->id">
                                            <span
                                                class="md:text-md m-auto flex text-center text-xs font-bold">{{ __($ecProduct->public_flg ? '非公開' : '公開') }}</span>
                                        </x-secondary-button>
                                    </x-card-item>
                                </x-card-box>
                            </x-card-box>
                        </x-update-card>
                    </form>
                @endforeach
            </div>
            <div class="w-full">
                {{ $ecProducts->render() }}
            </div>
        @endif
    </div>
@endsection
