<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index ()
    {
        // インデックスページ
        if (Auth::check()){
            // ユーザー情報取得
            $auth = Auth::user();
            // 管理者／一般
            if ($auth->admin_flg) {
                return redirect(route('ec_site.admin', ['auth' => $auth]));
            } else {
                return redirect(route('products.list', ['auth' => $auth]));
            }
        } else {
            return redirect(route('login'));
        }
    }
}
