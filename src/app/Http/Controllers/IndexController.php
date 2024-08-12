<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index ()
    {
        // ユーザー情報取得
        $auth = Auth::user();
        // インデックスページ
        if (Auth::check()){
            // 管理者／一般
            if ($auth->admin_flg) {
                return redirect(route('ec_site.admin'));
            } else {
                return redirect(route('items.index'));
            }
        } else {
            return redirect(route('login'));
        }
    }
}
