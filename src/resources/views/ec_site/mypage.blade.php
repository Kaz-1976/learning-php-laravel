@extends('layouts.layout')

@section('pagetitle', 'マイページ')

@section('content')
    <x-menu-button-box>
        <x-menu-button href="{{ url('/mypage/profile', null, app()->isProduction()) }}">個人情報</x-menu-button>
        <x-menu-button href="{{ url('/mypage/address', null, app()->isProduction()) }}">配送先情報</x-menu-button>
        <x-menu-button href="{{ url('/mypage/history', null, app()->isProduction()) }}">購入履歴</x-menu-button>
    </x-menu-button-box>
@endsection
