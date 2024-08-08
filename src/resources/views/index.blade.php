@extends('layout')

{{-- ページタイトル --}}
@section('PageTitle', 'ログイン')

{{-- ページコンテンツ --}}
@section('Content')
    <div class="container">
        <div class="container-item container-item-frame">
            <form class="ec-form" id="form-login" action={{ route('index') }} method="POST">
                @csrf
                <div class="ec-form-item">
                    <label class="ec-label" for="login-id">I D</label>
                    <span class="ec-input">
                        <input class="ec-input-text" type="text" name="login-id" id="login-id" value="">
                    </span>
                </div>
                <div class="ec-form-item">
                    <label class="ec-label" for="login-pw">パスワード</label>
                    <span class="ec-input">
                        <input class="ec-input-text" type="password" name="login-pw" id="login-pw" value="">
                    </span>
                </div>
                <div class="ec-form-item">
                    <input class="ec-input-checkbox" type="checkbox" name="cookie-confirmation" id="cookie-confirmation"
                        value="checked">
                    <label class="ec-input-checkbox-label" for="cookie-confirmation">次回ログインIDの入力を省略する</label>
                </div>
                <div class="ec-form-item">
                    <button class="ec-button" type="submit" form="form-login" name='action' value='login'>
                        <span class="ec-button-text-normal">ログイン</span>
                    </button>
                </div>
            </form>
        </div>
        <div class="container-item">
            <div class="ec-text ec-text-center">
                <p>アカウントをお持ちでない方は<a class="ec-text-bold" href="/register">こちら</a></p>
            </div>
        </div>
    </div>
@endsection
