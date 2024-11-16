@extends('layouts.layout')

@section('pagetitle', 'マイページ')

@section('content')
<div class="flex flex-col w-full gap-y-4 mx-auto">
    <a class="flex w-full basis-16 m-auto rounded text-2xl text-center font-bold bg-sky-500 dark:bg-sky-300"
        href="@generateUrl('mypage/profile')">
        <span class="flex m-auto">個人情報</span>
    </a>
    <a class="flex w-full basis-16 m-auto rounded text-2xl text-center font-bold bg-sky-500 dark:bg-sky-300"
        href="@generateUrl('mypage/address')">
        <span class="flex m-auto">配送先情報</span>
    </a>
    <a class="flex w-full basis-16 m-auto rounded text-2xl text-center font-bold bg-sky-500 dark:bg-sky-300"
        href="@generateUrl('mypage/history')">
        <span class="flex m-auto">購入履歴</span>
    </a>
</div>
@endsection
