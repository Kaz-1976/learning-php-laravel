<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        // ログインしてなければログインページへ
        $this->middleware('auth');

        // ユーザー属性チェック
        if (Auth::check()) {
            // ユーザー情報取得
            $auth = Auth::user();
            // 管理者／一般
            if (!$auth->admin_flg) {
                return redirect(route('ec_site.index', ['auth' => $auth]));
            }
        } else {
            return redirect(route('ec_site.index'));
        }
    }
}
