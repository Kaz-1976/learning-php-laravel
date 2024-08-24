<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        // インデックスページ
        if (Auth::check()) {
            // ユーザー情報取得
            $user = Auth::user();
            // 管理者／一般
            if ($user->admin_flg) {
                return redirect(route('ec_site.admin'));
            } else {
                return redirect(route('items.index'));
            }
        }
        return redirect(route('login'));
    }
}
