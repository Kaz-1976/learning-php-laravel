@extends('layouts.layout')

@section('pagetitle','管理メニュー')

@section('content')
<div class="container-item container-item-frame">
    <form class="ec-menu-button" id="form-link-admin-users" action="./admin-users.php" method="POST">
        <input type="hidden" name="csrf-token" value="<?php echo $token; ?>">
        <button class="ec-button" type="submit" form="form-link-admin-users" name="action" value="admin-users">
            <span class="ec-menu-button-text">ユーザー管理</span>
        </button>
    </form>
    <form class="ec-menu-button" id="form-link-admin-products" action="./admin-products.php" method="POST">
        <input type="hidden" name="csrf-token" value="<?php echo $token; ?>">
        <button class="ec-button" type="submit" form="form-link-admin-products" name="action" value="admin-products">
            <span class="ec-menu-button-text">商品管理</span>
        </button>
    </form>
</div>
@endsection
