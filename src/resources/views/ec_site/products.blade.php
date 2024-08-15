@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '商品管理')

{{-- ページコンテンツ --}}
@section('content')
    <div class="container flex flex-col gap-4">
        <div class="container p-4 border-solid border-2 border-sky-50 rounded-lg">
            <form class="flex flex-row gap-4" id="register" action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="flex flex-col grow-0 basis-80 h-80">
                    <div class="block w-80 h-80 border-solid border-2 border-sky-50">

                    </div>
                </div>
                <div class="flex flex-col grow">
                    {{-- 商品名 --}}
                    <div>
                        <x-input-label for="register-product-name" :value="__('商品名')" />
                        <x-text-input class="block mt-1 w-full" type="text" id="register-product-name"
                            name="product_name" :value="old('product_name')" required autofocus />
                        <x-input-error :messages="$errors->get('product_name')" class="mt-2" />
                    </div>
                    {{-- 数量 --}}
                    <div>
                        <x-input-label for="register-product-qty" :value="__('数量')" />
                        <x-text-input class="block mt-1 w-full text-right" type="number" id="register-qty" name="qty"
                            :value="old('stock_qty')" required autofocus />
                        <x-input-error :messages="$errors->get('qty')" class="mt-2" />
                    </div>
                    {{-- 価格 --}}
                    <div>
                        <x-input-label for="register-price" :value="__('価格')" />
                        <x-text-input class="block mt-1 w-full text-right" type="number" id="register-price" name="price"
                            :value="old('price')" required autofocus />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>
                    {{-- 画像 --}}
                    <div>
                        <x-input-label for="register-image" :value="__('画像')" />
                        <x-text-input class="block mt-1 w-full" type="file" id="register-image" name="image"
                            required />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                    <div class="pt-4 flex flex-row justify-between">
                        <div class="my-auto flex flex-row basis-1/4">
                            <x-text-input class="w-8 h-8" type="checkbox" id="register-public" name="public"
                                :value="old('public_flg')" autofocus autocomplete="public_flg" />
                            <x-input-label class="my-auto pl-2 flex" for="register-public" :value="__('公開')" />
                            <x-input-error :messages="$errors->get('public_flg')" class="mt-2" />
                        </div>
                        <div class="my-auto flex flex-row basis-2/4">
                            <x-primary-button class="flex basis-full">
                                <span class="flex m-auto text-2xl text-center font-bold">{{ __('Register') }}</span>
                            </x-primary-button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="container">
            @foreach ($ec_products as $ec_product)
                <div
                    class="w-full p-4 flex flex-row basis-full gap-2 border-b-2 border-sky-50 {{ $ec_product->enable_flg ? ($ec_product->admin_flg ? 'bg-sky-800' : 'bg-sky-700') : 'bg-sky-900' }}">
                    <form class="flex flex-row basis-full gap-2" id="update-products-{{ $ec_product->id }}"
                        action="{{ route('products.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $ec_product->id }}" />
                        <input type="hidden" name="enable_flg" value="{{ $ec_product->enable_flg }}" />
                        <input type="hidden" name="admin_flg" value="{{ $ec_product->admin_flg }}" />
                        <div class="flex flex-col basis-4/5 gap-1">
                            <div class="block">
                                <x-input-label for="update-product-id-{{ $ec_product->id }}" :value="__('ID')" />
                                <x-text-input class="block mt-1 w-full" type="text"
                                    id="update-product-id-{{ $ec_product->id }}" name="product_id" :value="$ec_product->product_id"
                                    :disabled="$ec_product->product_id === env('DEFAULT_ADMIN_ID', 'ec_admin')" required autofocus autocomplete="product_id" placeholder="EcTaro" />
                                <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                            </div>
                            <div class="block">
                                <x-input-label for="update-product-name-{{ $ec_product->id }}" :value="__('氏名（漢字）')" />
                                <x-text-input class="block mt-1 w-full" type="text"
                                    id="update-product-name-{{ $ec_product->id }}" name="product_name" :value="$ec_product->product_name"
                                    required autofocus autocomplete="product_name" placeholder="イーシー太郎" />
                                <x-input-error :messages="$errors->get('product_name')" class="mt-2" />
                            </div>
                            <div class="block">
                                <x-input-label for="update-product-kana-{{ $ec_product->id }}" :value="__('氏名（かな）')" />
                                <x-text-input class="block mt-1 w-full" type="text"
                                    id="update-product-kana-{{ $ec_product->id }}" name="product_kana" :value="$ec_product->product_kana"
                                    required autofocus autocomplete="product_kana" placeholder="いーしーたろう" />
                                <x-input-error :messages="$errors->get('product_kana')" class="mt-2" />
                            </div>
                            <div class="block">
                                <x-input-label for="update-email-{{ $ec_product->id }}" :value="__('Email')" />
                                <x-text-input class="block mt-1 w-full" type="text"
                                    id="update-email-{{ $ec_product->id }}" name="email" :value="$ec_product->email" required
                                    autofocus autocomplete="email" placeholder="ec-taro@example.local" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div class="block">
                                <x-input-label for="update-password-{{ $ec_product->id }}" :value="__('Password')" />
                                <x-text-input class="block mt-1 w-full" type="password"
                                    id="update-password-{{ $ec_product->id }}" name="password"
                                    autocomplete="new-password" placeholder="ABCabc0123!@#$%^&*" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div class="block">
                                <x-input-label for="update-password-confirm-{{ $ec_product->id }}" :value="__('Confirm Password')" />
                                <x-text-input class="block mt-1 w-full" type="password"
                                    id="update-password-confirm-{{ $ec_product->id }}" name="password_confirmation"
                                    autocomplete="new-password" placeholder="ABCabc0123!@#$%^&*" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        </div>
                        <div class="flex flex-col basis-1/5 gap-2">
                            <div class="flex basis-full">
                                @if ($ec_product->product_id != env('DEFAULT_ADMIN_ID', 'ec_admin'))
                                    <x-primary-button class="w-full" name="enable">
                                        <span
                                            class="flex m-auto text-2xl text-center font-bold">{{ __($ec_product->enable_flg ? '無効' : '有効') }}</span>
                                    </x-primary-button>
                                @endif
                            </div>
                            <div class="flex basis-full">
                                @if ($ec_product->product_id != env('DEFAULT_ADMIN_ID', 'ec_admin'))
                                    <x-primary-button class="w-full" name="admin">
                                        <span
                                            class="flex m-auto text-2xl text-center font-bold">{{ __($ec_product->admin_flg ? '一般' : '管理者') }}</span>
                                    </x-primary-button>
                                @endif
                            </div>
                            <div class="flex basis-full">
                                <x-primary-button class="w-full" name="update">
                                    <span class="flex m-auto text-2xl text-center font-bold">{{ __('更新') }}</span>
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection
