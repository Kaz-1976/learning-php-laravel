@extends('layouts.layout')

@section('pagetitle', '管理メニュー')

@section('content')
    <x-menu-button-box>
        <x-menu-button href="{{ url('/admin/users', null, app()->isProduction()) }}">ユーザー管理</x-menu-button>
        @if (Auth::user()->user_id != env('DEFAULT_ADMIN_ID', 'ec_admin'))
            <x-menu-button href="{{ url('/admin/products', null, app()->isProduction()) }}">商品管理</x-menu-button>
        @endif
    </x-menu-button-box>
@endsection
