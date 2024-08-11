<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    public function index ()
    {
        // インデックスページ
        if (Auth::check()){
            // ユーザー情報取得
            $auth = Auth::user();
            // 管理者なら管理メニューへ
            if ($auth->admin_flg) {
                return redirect(route('ec_site.admin', ['auth' => $auth]));
            }
        } else {
            return redirect(route('login'));
        }
        // 商品情報


    }
}
