<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        // インデックスページ
        if (Auth::check()) {
            // ユーザー情報取得
            $user = Auth::user();
            // 管理／一般
            if ($user->admin_flg == 0) {
                // 一般ユーザーは商品一覧へ
                return redirect(route('items.index'));
            } else {
                // 管理ユーザーは管理メニューへ
                return redirect(route('ec_site.admin'));
            }
        }
        // ログインしていない場合はログインページへ
        return redirect(route('login'));
    }
}
