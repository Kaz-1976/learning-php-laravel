@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '商品管理')

{{-- ページコンテンツ --}}
@section('content')
<div class="container flex flex-col gap-4">
    <div class="container p-4 border-solid border-2 rounded-lg border-sky-950 dark:border-sky-50">
        <form class="flex flex-row gap-4" id="register"
            action="{{ url('ec_site/admin/products/store', null, app()->isProduction()) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col grow-0 basis-80 h-80 m-auto">
                <div class="flex w-80 h-80 border-solid border-2 border-sky-50">
                    <img id="register-image-preview">
                </div>
            </div>
            <div class="flex flex-col grow">
                {{-- 商品名 --}}
                <div>
                    <x-input-label for="register-product-name" :value="__('商品名')" />
                    <x-text-input class="block mt-1 w-full" type="text" id="register-product-name" name="name"
                        :value="old('name')" required autofocus />
                    @if (old('register') == '1')
                    <x-input-error :messages="$errors->get('name')" class="my-2" />
                    @endif
                </div>
                {{-- 数量 --}}
                <div>
                    <x-input-label for="register-qty" :value="__('数量')" />
                    <div class="flex flex-row content-stretch gap-2">
                        <x-text-input class="basis-auto mt-1 w-full text-right" type="number" id="register-qty"
                            name="qty" :value="old('qty')" required autofocus />
                        <x-input-label class="mt-auto" for="register-qty" :value="__('点')" />
                    </div>
                    @if (old('register') == '1')
                    <x-input-error :messages="$errors->get('qty')" class="my-2" />
                    @endif
                </div>
                {{-- 価格 --}}
                <div>
                    <x-input-label for="register-price" :value="__('価格')" />
                    <div class="flex flex-row content-stretch gap-2">
                        <x-text-input class="block mt-1 w-full text-right" type="number" id="register-price"
                            name="price" :value="old('price')" required autofocus />
                        <x-input-label class="mt-auto" for="register-qty" :value="__('円')" />
                    </div>
                    @if (old('register') == '1')
                    <x-input-error :messages="$errors->get('price')" class="my-2" />
                    @endif
                </div>
                {{-- 画像 --}}
                <div>
                    <x-input-label for="register-image" :value="__('画像')" />
                    <x-text-input class="block mt-1 w-full" type="file" id="register-image" name="image" required
                        accept="image/*" />
                    @if (old('register') == '1')
                    <x-input-error :messages="$errors->get('image')" class="my-2" />
                    @endif
                </div>
                <div class="pt-4 flex flex-row justify-between gap-2">
                    <div class="my-auto flex flex-row basis-1/5">
                        <x-text-input class="w-8 h-8" type="checkbox" id="register-public" name="public_flg"
                            :value="old('public_flg')" autofocus />
                        <x-input-label class="my-auto pl-2 flex" for="register-public" :value="__('公開')" />
                        @if (old('register') == '1')
                        <x-input-error :messages="$errors->get('public_flg')" class="my-2" />
                        @endif
                    </div>
                    <div class="flex flex-row-reverse basis-4/5 gap-2">
                        <div class="my-auto flex flex-row basis-1/2">
                            <x-primary-button class="flex basis-full" name="register" :value="1">
                                <span class="flex m-auto text-2xl text-center font-bold">{{ __('Register') }}</span>
                            </x-primary-button>
                        </div>
                        <div class="my-auto flex flex-row basis-1/2">
                            <x-secondary-button class="flex basis-full" type='reset' name="reset" :value="1">
                                <span class="flex m-auto text-2xl text-center font-bold">{{ __('リセット') }}</span>
                            </x-secondary-button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="container w-full">
        {{ $ec_products->render() }}
    </div>
    <div class="container">
        @php
        $id = [];
        $form = [];
        $image = [];
        @endphp
        @foreach ($ec_products as $ec_product)
        @php
        $id[] = $ec_product->id;
        $form[$ec_product->id] = 'update-' . (string) $ec_product->id;
        $image[$ec_product->id] = 'data:' . $ec_product->image_type . ';base64,' . $ec_product->image_data;
        @endphp
        <div
            class="w-full p-4 flex flex-row basis-full gap-2 {{ $loop->first ? 'border-t-2' : '' }} border-b-2 border-sky-950 dark:border-sky-50 {{ $ec_product->public_flg ? 'bg-sky-400 dark:bg-sky-700' : 'bg-sky-200 dark:bg-sky-900' }}">
            <form class="flex flex-row basis-full gap-2" id="{{ $form[$ec_product->id] }}"
                action="{{ url('ec_site/admin/products/update', null, app()->isProduction()) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $ec_product->id }}" />
                <input type="hidden" name="public_flg" value="{{ $ec_product->public_flg }}" />
                <div class="flex flex-col grow-0 basis-64 h-64 m-auto">
                    <div class="block w-64 h-64 border-solid border-2 border-sky-50">
                        <img class="block w-full h-hull object-cover overflow-hidden"
                            id="{{ $form[$ec_product->id] }}-image-preview" src="{{ $image[$ec_product->id] }}">
                    </div>
                </div>
                <div class="flex flex-row grow gap-2">
                    <div class="flex flex-col basis-4/5 gap-1">
                        <div class="block">
                            <x-input-label for="{{ $form[$ec_product->id] }}-name" :value="__('名称')" />
                            <x-text-input class="block mt-1 w-full" type="text" id="{{ $form[$ec_product->id] }}-name"
                                name="name" :value="$ec_product->name" required autofocus autocomplete="name" />
                            @if (old('update') == $ec_product->id)
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            @endif
                        </div>
                        <div class="block">
                            <x-input-label for="{{ $form[$ec_product->id] }}-qty" :value="__('数量')" />
                            <div class="flex flex-row content-stretch gap-2">
                                <x-text-input class="block mt-1 w-full text-right" type="number"
                                    id="{{ $form[$ec_product->id] }}-qty" name="qty" :value="$ec_product->qty" required
                                    autofocus />
                                <x-input-label class="mt-auto" for="{{ $form[$ec_product->id] }}-qty"
                                    :value="__('点')" />
                            </div>
                            @if (old('update') == $ec_product->id)
                            <x-input-error :messages="$errors->get('qty')" class="mt-2" />
                            @endif
                        </div>
                        <div class="block">
                            <x-input-label for="{{ $form[$ec_product->id] }}-price" :value="__('価格')" />
                            <div class="flex flex-row content-stretch gap-2">
                                <x-text-input class="block mt-1 w-full text-right" type="number"
                                    id="{{ $form[$ec_product->id] }}-price" name="price" :value="$ec_product->price"
                                    required autofocus />
                                <x-input-label class="mt-auto" for="{{ $form[$ec_product->id] }}-price"
                                    :value="__('円')" />
                            </div>
                            @if (old('update') == $ec_product->id)
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            @endif
                        </div>
                        <div>
                            <x-input-label for="{{ $form[$ec_product->id] }}-image" :value="__('画像')" />
                            <x-text-input class="block mt-1 w-full" type="file" id="{{ $form[$ec_product->id] }}-image"
                                name="image" accept="image/*" />
                            @if (old('update') == $ec_product->id)
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col-reverse basis-1/5 gap-2">
                        <div class="flex basis-full">
                            <x-primary-button class="w-full" id="{{ $form[$ec_product->id] }}-btn-submit"
                                form="{{ $form[$ec_product->id] }}" name="update" :value="$ec_product->id">
                                <span class="flex m-auto text-xl text-center font-bold">{{ __('更新') }}</span>
                            </x-primary-button>
                        </div>
                        <div class="flex basis-full">
                            <x-secondary-button class="w-full" id="{{ $form[$ec_product->id] }}-btn-reset" type="reset"
                                name="reset">
                                <span class="flex m-auto text-xl text-center font-bold">{{ __('リセット') }}</span>
                            </x-secondary-button>
                        </div>
                        <div class="flex basis-full">
                            <x-secondary-button class="w-full" id="{{ $form[$ec_product->id] }}-btn-public"
                                type="submit" name="public" :value="$ec_product->id">
                                <span
                                    class="flex m-auto text-xl text-center font-bold">{{ __($ec_product->public_flg ? '非公開' : '公開') }}</span>
                            </x-secondary-button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @endforeach
    </div>
    <div class="container w-full">
        {{ $ec_products->render() }}
    </div>
</div>
<script>
    // ------------------------------------------------------------
        // 画面ロード時実行関数
        // ------------------------------------------------------------
        window.addEventListener('DOMContentLoaded', () => {
            // 定数設定
            const ids = @json($id);
            const forms = @json($form);
            const images = @json($image);

            // ------------------------------------------------------------
            // 登録フォーム用処理登録
            // ------------------------------------------------------------
            // 画像ロード処理
            loadImage('register-image', 'register-image-preview');
            // フォームリセット時画像消去
            productFormReset('register', '');

            // ------------------------------------------------------------
            // 更新フォーム用処理登録
            // ------------------------------------------------------------
            ids.forEach(id => {
                // 画像ロード処理
                loadImage(forms[id] + '-image', forms[id] + '-image-preview');
                // フォームリセット時画像消去
                productFormReset(forms[id], images[id]);
            });
        }, false);
</script>
@endsection