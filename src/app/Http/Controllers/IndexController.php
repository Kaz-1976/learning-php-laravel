<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        // インデックスページ
        if (Auth::check()) {
            // 管理／一般
            if (Auth::user()->admin_flg == 0) {
                // 一般ユーザーは商品一覧へ
                return redirect(url('/items', null, app()->isProduction()));
            } else {
                // 管理ユーザーは管理メニューへ
                return redirect(url('/admin', null, app()->isProduction()));
            }
        }
        // ログインしていない場合はログインページへ
        return redirect(url('/login', null, app()->isProduction()));
    }
}
