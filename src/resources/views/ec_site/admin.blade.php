@extends('layouts.layout')

@section('pagetitle', '管理メニュー')

@section('content')
<div class="flex flex-col w-full gap-y-4 mx-auto">
    <a class="flex w-full basis-16 m-auto rounded text-2xl text-center font-bold bg-sky-500 dark:bg-sky-300"
        href="{{ url('ec_site/admin/users', null, app()->isProduction()) }}">
        <span class="flex m-auto">ユーザー管理</span>
    </a>
    @if (Auth::user()->user_id != env('DEFAULT_ADMIN_ID', 'ec_admin'))
    <a class="flex w-full basis-16 m-auto rounded text-2xl text-center font-bold bg-sky-500 dark:bg-sky-300"
        href="{{ url('ec_site/admin/products', null, app()->isProduction()) }}">
        <span class="flex m-auto">商品管理</span>
    </a>
    @endif
</div>
@endsection