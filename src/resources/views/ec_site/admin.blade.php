@extends('layouts.layout')

@section('pagetitle', '管理メニュー')

@section('content')
    <div class="container flex flex-col w-full gap-y-1 my-4">
        <a class="w-full h-16 flex m-auto rounded text-2xl text-center font-bold bg-sky-500 dark:bg-sky-300"
            href="{{ route('users.index') }}">
            <div class="flex m-auto">
                ユーザー管理
            </div>
        </a>
        @if (Auth::user()->user_id != env('DEFAULT_ADMIN_ID', 'ec_admin'))
            <a class="w-full h-16 flex m-auto rounded text-2xl text-center font-bold bg-sky-500 dark:bg-sky-300"
                href="{{ route('products.index') }}">
                <div class="flex m-auto">
                    商品管理
                </div>
            </a>
        @endif
    </div>
@endsection
