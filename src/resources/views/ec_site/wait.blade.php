@extends('layouts.layout')

@section('pagetitle', 'ログイン待機')

@section('content')
    <x-empty-string-box>
        しばらくお待ちください。
    </x-empty-string-box>
@endsection

@section('script')
    <script>
        @if (session('apiAccessToken'))
            // トークン取得
            const token = "{{ session('apiAccessToken') }}";
            localStorage.setItem('apiAccessToken', token);
        @endif
        // リダイレクト
        location.href = '/'
    </script>
@endsection
