@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '商品管理')

{{-- ページコンテンツ --}}
@section('content')
    <div class="flex flex-col gap-4">
        <form class="flex flex-col md:flex-row gap-4 p-4 border-solid border-2 rounded-lg border-sky-950 dark:border-sky-50"
            id="register" action="{{ url('/admin/products/store', null, app()->isProduction()) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <x-image-box class="w-64 md:w-80 h-64 md:h-80 basis-64 md:basis-80" image-id="register-image-preview" />
            <div class="flex flex-col grow gap-4">
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
                        <x-text-input class="block mt-1 w-full text-right" type="number" id="register-price" name="price"
                            :value="old('price')" required autofocus />
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
                <div class="flex flex-row justify-between gap-2">
                    <div class="my-auto flex flex-row basis-[30%] md:basis-1/5">
                        <x-text-input class="w-8 h-8" type="checkbox" id="register-public" name="public_flg"
                            :value="old('public_flg')" autofocus />
                        <x-input-label class="my-auto pl-2 flex" for="register-public" :value="__('公開')" />
                        @if (old('register') == '1')
                            <x-input-error :messages="$errors->get('public_flg')" class="my-2" />
                        @endif
                    </div>
                    <div class="flex flex-row-reverse basis-[70%] md:basis-4/5 gap-2">
                        <div class="my-auto flex flex-row basis-1/2">
                            <x-primary-button class="flex basis-full" name="register" :value="1">
                                <span
                                    class="flex m-auto text-xs md:text-xl text-center font-bold">{{ __('Register') }}</span>
                            </x-primary-button>
                        </div>
                        <div class="my-auto flex flex-row basis-1/2">
                            <x-secondary-button class="flex basis-full" type='reset' name="reset" :value="1">
                                <span
                                    class="flex m-auto text-xs md:text-xl text-center font-bold">{{ __('リセット') }}</span>
                            </x-secondary-button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @if ($ecProducts->isEmpty())
            <div class="flex flex-row flex-wrap py-2 border-t-2 border-b-2 border-sky-950 dark:border-sky-50">
                <x-empty-string-box>商品が登録されていません。</x-empty-string-box>
            </div>
        @else
            <div class="w-full">
                {{ $ecProducts->render() }}
            </div>
            <div class="w-full">
                @foreach ($ecProducts as $ecProduct)
                    <div
                        class="w-full p-4 flex flex-row basis-full gap-2 {{ $loop->first ? 'border-t-2' : '' }} border-b-2 border-sky-950 dark:border-sky-50 {{ $ecProduct->public_flg ? 'bg-sky-400 dark:bg-sky-700' : 'bg-sky-200 dark:bg-sky-900' }}">
                        <form class="flex flex-col md:flex-row basis-full gap-2" id="update-{{ $ecProduct->id }}"
                            action="{{ url('/admin/products/update', null, app()->isProduction()) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $ecProduct->id }}" />
                            <input type="hidden" name="public_flg" value="{{ $ecProduct->public_flg }}" />
                            <x-image-box class="w-64 h-64" image-id="update-{{ $ecProduct->id }}-image-preview"
                                image-url="{{ url('/api/product-image/' . $ecProduct->id, null, app()->isProduction()) }}"
                                image-alt="{{ $ecProduct->name }}" image-title="{{ $ecProduct->name }}" />
                            <div class="flex flex-col md:flex-row grow gap-4">
                                <div class="flex flex-col basis-4/5 gap-1">
                                    <div class="block">
                                        <x-input-label for="update-{{ $ecProduct->id }}-name" :value="__('名称')" />
                                        <x-text-input class="block mt-1 w-full" type="text"
                                            id="update-{{ $ecProduct->id }}-name" name="name" :value="$ecProduct->name"
                                            required autofocus autocomplete="name" />
                                        @if (old('update') == $ecProduct->id)
                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                        @endif
                                    </div>
                                    <div class="block">
                                        <x-input-label for="update-{{ $ecProduct->id }}-qty" :value="__('数量')" />
                                        <div class="flex flex-row content-stretch gap-2">
                                            <x-text-input class="block mt-1 w-full text-right" type="number"
                                                id="update-{{ $ecProduct->id }}-qty" name="qty" :value="$ecProduct->qty"
                                                required autofocus />
                                            <x-input-label class="mt-auto" for="update-{{ $ecProduct->id }}-qty"
                                                :value="__('点')" />
                                        </div>
                                        @if (old('update') == $ecProduct->id)
                                            <x-input-error :messages="$errors->get('qty')" class="mt-2" />
                                        @endif
                                    </div>
                                    <div class="block">
                                        <x-input-label for="update-{{ $ecProduct->id }}-price" :value="__('価格')" />
                                        <div class="flex flex-row content-stretch gap-2">
                                            <x-text-input class="block mt-1 w-full text-right" type="number"
                                                id="update-{{ $ecProduct->id }}-price" name="price" :value="$ecProduct->price"
                                                required autofocus />
                                            <x-input-label class="mt-auto" for="update-{{ $ecProduct->id }}-price"
                                                :value="__('円')" />
                                        </div>
                                        @if (old('update') == $ecProduct->id)
                                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                        @endif
                                    </div>
                                    <div>
                                        <x-input-label for="update-{{ $ecProduct->id }}-image" :value="__('画像')" />
                                        <x-text-input class="block mt-1 w-full" type="file"
                                            id="update-{{ $ecProduct->id }}-image" name="image" accept="image/*" />
                                        @if (old('update') == $ecProduct->id)
                                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                        @endif
                                    </div>
                                </div>
                                <div class="flex flex-row-reverse md:flex-col-reverse basis-1/5 gap-2">
                                    <div class="flex basis-full">
                                        <x-primary-button class="w-full" id="update-{{ $ecProduct->id }}-btn-submit"
                                            form="update-{{ $ecProduct->id }}" name="update" :value="$ecProduct->id">
                                            <span
                                                class="flex m-auto text-xs md:text-xl text-center font-bold">{{ __('更新') }}</span>
                                        </x-primary-button>
                                    </div>
                                    <div class="flex basis-full">
                                        <x-secondary-button class="w-full" id="update-{{ $ecProduct->id }}-btn-reset"
                                            type="reset" name="reset">
                                            <span
                                                class="flex m-auto text-xs md:text-xl text-center font-bold">{{ __('リセット') }}</span>
                                        </x-secondary-button>
                                    </div>
                                    <div class="flex basis-full">
                                        <x-secondary-button class="w-full" id="update-{{ $ecProduct->id }}-btn-public"
                                            type="submit" name="public" :value="$ecProduct->id">
                                            <span
                                                class="flex m-auto text-xs md:text-xl text-center font-bold">{{ __($ecProduct->public_flg ? '非公開' : '公開') }}</span>
                                        </x-secondary-button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
            <div class="w-full">
                {{ $ecProducts->render() }}
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            // 画像選択時の処理
            const inputs = document.querySelectorAll('input[type="file"]');
            inputs.forEach((input) => {
                input.addEventListener('change', (event) => {
                    loadProductImage(event);
                });
            });
            // フォームリセット時画像消去
            const buttons = document.querySelectorAll('button[type="reset"]');
            buttons.forEach((button) => {
                button.addEventListener('click', (event) => {
                    resetProductImage(event);
                });
            });
        });
    </script>
@endsection
