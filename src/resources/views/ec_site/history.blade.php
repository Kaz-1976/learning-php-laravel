@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', '購入履歴')

{{-- ページコンテンツ --}}
@section('content')
    @if ($ecReceipts->isEmpty())
        {{-- ヘッダー --}}
        <x-link-button-box>
            <x-link-button class="basis-full" link-type="link" link-to="{{ url('/mypage', null, app()->isProduction()) }}">
                マイページ
            </x-link-button>
        </x-link-button-box>
        {{-- 本体 --}}
        <x-empty-string-box>購入履歴がありません。</x-empty-string-box>
        {{-- フッター --}}
        <x-link-button-box>
            <x-link-button class="basis-full" link-type="link" link-to="{{ url('/mypage', null, app()->isProduction()) }}">
                マイページ
            </x-link-button>
        </x-link-button-box>
    @else
        {{-- ヘッダー --}}
        <x-link-button-box>
            <x-link-button class="basis-full" link-type="link" link-to="{{ url('/mypage', null, app()->isProduction()) }}">
                マイページ
            </x-link-button>
        </x-link-button-box>
        {{-- 本体 --}}
        <div class="w-full pb-2">
            {{ $ecReceipts->render() }}
        </div>
        <div class="flex flex-col">
            @foreach ($ecReceipts as $ecReceipt)
            @endforeach
        </div>
        <div class="w-full pt-2">
            {{ $ecReceipts->render() }}
        </div>
        {{-- フッター --}}
        <x-link-button-box>
            <x-link-button class="basis-full" link-type="link" link-to="{{ url('/mypage', null, app()->isProduction()) }}">
                マイページ
            </x-link-button>
        </x-link-button-box>
    @endif
@endsection
