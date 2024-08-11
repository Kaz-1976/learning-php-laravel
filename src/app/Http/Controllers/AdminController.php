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
    }

    public function index ()
    {
        // ユーザー情報取得
        $auth = Auth::user();

        // ユーザー属性チェック
        if (Auth::check()) {
            // 管理者／一般
            if (!$auth->admin_flg) {
                return redirect(route('ec_site.index'));
            }
        } else {
            return redirect(route('ec_site.index'));
        }

        // 管理メニュー
        return view('ec_site.admin');
    }
}
