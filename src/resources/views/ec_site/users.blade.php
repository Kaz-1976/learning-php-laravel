@extends('layouts.layout')

{{-- ページタイトル --}}
@section('pagetitle', 'ユーザー管理')

{{-- ページコンテンツ --}}
@section('content')
<div class="container">
    <div class="ec-page-title">
        <h2>@yield('pagetitle')</h2>
    </div>
    <div class="container-item container-item-frame">
        <form class="ec-form-register" id="register-users" action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="ec-form-register-item">
                <label class="ec-label" for="register-users-user-id">I D</label>
                <span class="ec-input">
                    <input class="ec-input-text" type="text" id="register-users-user-id" name="user_id" value="{{ old('user_id') }}" placeholder="EcTaro">
                </span>
            </div>
            <div class="ec-form-register-item">
                <label class="ec-label" for="register-users-user-password">パスワード</label>
                <span class="ec-input">
                    <input class="ec-input-text" type="password" id="register-users-user-password" name="user_password" value="{{ old('user_password') }}" placeholder="ABCabc0123!@#$%^&*">
                </span>
            </div>
            <div class="ec-form-register-item">
                <label class="ec-label" for="register-users-user-name">氏名（漢字）</label>
                <span class="ec-input">
                    <input class="ec-input-text" type="text" id="register-users-user-name" name="user_name" value="{{ old('user_name') }}" placeholder="イーシー太郎">
                </span>
            </div>
            <div class="ec-form-register-item">
                <label class="ec-label" for="register-users-user-kana">氏名（かな）</label>
                <span class="ec-input">
                    <input class="ec-input-text" type="text" id="register-users-user-kana" name="user_kana" value="{{ old('user_kana') }}" placeholder="いーしーたろう">
                </span>
            </div>
            <div class="ec-form-register-item">
                <label class="ec-label" for="register-users-user-mail">メールアドレス</label>
                <span class="ec-input">
                    <input class="ec-input-text" type="email" id="register-users-user-mail" name="user_mail" value="{{ old('user_mail') }}" placeholder="ec-taro@example.local">
                </span>
            </div>
            <div class="ec-form-register-item">
                <div class="ec-form-register-input">
                    <input class="ec-input-checkbox" type="checkbox" id="register-users-user-enable" name="user_enable" >
                    <label class="ec-input-checkbox-label" for="register-users-user-enable">有効</label>
                </div>
                <div class="ec-form-register-input">
                    <input class="ec-input-checkbox" type="checkbox" id="register-users-user-admin" name="user_admin">
                    <label class="ec-input-checkbox-label" for=" register-users-user-admin">管理者</label>
                </div>
                <div class="ec-form-register-button">
                    <button class="ec-button" type="submit" form="register-users" name="action" value="create">
                        <span class="ec-button-text-small">登録</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="container-item container-item-noframe">
        @foreach ($ec_users as $ec_user)
        <div class="ec-form-update-wrapper {{ ( $ec_user->enable_flg === 0 ) ? 'ec-list-disable' : '' }} {{ ( $ec_user->admin_flg === 1 ) ? 'ec-list-admin' : '' }}">
            <form class="ec-form-update" id="update-users-{{ $ec_user->id }}" action="{{ route('users.update') }}" method="POST">
                @csrf
                <input type="hidden" id="id-{{ $ec_user->id }}" name="id" value="{{ $ec_user->id }}">
                <input type="hidden" id="user-enable-{{ $ec_user->id }}" name="user-enable" value="{{ $ec_user->enable_flg }}">
                <input type="hidden" id="user-admin-{{ $ec_user->id }}" name="user-admin" value="{{ $ec_user->admin_flg }}">
                <div class="ec-form-update-input">
                    <div class="ec-form-update-input-item">
                        <label class="ec-label" for="list-user-id-{{ $ec_user->id }}">I D</label>
                        <span class="ec-input">
                            <input class="ec-input-text" type="text" id="list-user-id-{{ $ec_user->id }}" name="list-user-id" value="{{ $ec_user->user_id }}" placeholder="EcTaro">
                        </span>
                    </div>
                    <div class="ec-form-update-input-item">
                        <label class="ec-label" for="register-users-user-password">パスワード</label>
                        <span class="ec-input">
                            <input class="ec-input-text" type="password" id="register-users-user-password" name="user-password" value="" placeholder="ABCabc0123!@#$%^&*">
                        </span>
                    </div>
                    <div class="ec-form-update-input-item">
                        <label class="ec-label" for="list-user-name-{{ $ec_user->id }}">氏名（漢字）</label>
                        <span class="ec-input">
                            <input class="ec-input-text" type="text" id="list-user-name-{{ $ec_user->id }}" name="list-user-name" value="{{ $ec_user->user_name }}" placeholder="イーシー太郎">
                        </span>
                    </div>
                    <div class="ec-form-update-input-item">
                        <label class="ec-label" for="list-user-kana-{{ $ec_user->id }}">氏名（かな）</label>
                        <span class="ec-input">
                            <input class="ec-input-text" type="text" id="list-user-kana-{{ $ec_user->id }}" name="list-user-kana" value="{{ $ec_user->user_kana }}" placeholder="いーしーたろう">
                        </span>
                    </div>
                    <div class="ec-form-update-input-item">
                        <label class="ec-label" for="list-user-mail-{{ $ec_user->id }}">メールアドレス</label>
                        <span class="ec-input">
                            <input class="ec-input-text" type="email" id="list-user-mail-{{ $ec_user->id }}" name="list-user-mail" value="{{ $ec_user->email }}" placeholder="ec-taro@example.local">
                        </span>
                    </div>
                </div>
                <div class="ec-form-update-button">
                    <div class="ec-form-update-button-item">
                        <button class="ec-button" type="submit" form="update-users-{{ $ec_user->id }}" name="action" value="enable">
                            <span class="ec-button-text-small">{{ $ec_user->enable_flg === 1 ? '無効' : '有効' }}</span>
                        </button>
                    </div>
                    <div class="ec-form-update-button-item">
                        <button class="ec-button" type="submit" form="update-users-{{ $ec_user->id }}" name="action" value="admin">
                            <span class="ec-button-text-small">{{ $ec_user->admin_flg === 1 ? '一般' : '管理者' }}</span>
                        </button>
                    </div>
                    <div class="ec-form-update-button-item">
                        <button class="ec-button" type="submit" form="update-users-{{ $ec_user->id }}" name="action" value="update">
                            <span class="ec-button-text-small">更新</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @endforeach
    </div>
  </div>
@endsection
