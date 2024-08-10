<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EcUser;

use function PHPUnit\Framework\isEmpty;

class EcUserController extends Controller
{
    // ログインしてなければログインページへ
    public function __construct(){
        $this->middleware('auth');
    }

    // 一覧表示
    public function index()
    {
        //
        $ec_users = EcUser::all();
        //
        return view('ec_site/users', [ 'ec_users' => $ec_users ]);
    }

    // ユーザー登録
    public function store(Request $request)
    {
        // ユーザー生成
        $ec_user = new EcUser();
        // ユーザー設定
        $ec_user->user_id = $request->user_id;
        $ec_user->user_name = $request->user_name;
        $ec_user->user_kana = $request->user_kana;
        $ec_user->email = $request->user_mail;
        $ec_user->password = password_hash($request->user_password, PASSWORD_DEFAULT);
        $ec_user->admin_flg = $request->user_admin === 1 ? true : false;
        $ec_user->enable_flg = $request->user_enable === 1 ? true : false;
        $ec_user->last_login_at = null;
        $ec_user->email_verified_at = null;
        // ユーザー登録
        $ec_user->save();
        // リダイレクト
        return redirect('/ec_site/users');
    }

    // ユーザー更新
    public function update(Request $request)
    {
        // ユーザー設定
        switch ($request->action) {
            case 'admin':
                $ec_user = EcUser::select('admin_flg')->find($request->id);
                $ec_user->admin_flg = $request->user_admin === 1 ? false : true;
                break;
            case 'enable':
                $ec_user = EcUser::select('enable_flg')->find($request->id);
                $ec_user->enable_flg = $request->user_enable === 1 ? false : true;
                break;
            case 'update':
                $ec_user = EcUser::find($request->id);
                $ec_user->user_id = $request->user_id;
                $ec_user->user_name = $request->user_name;
                $ec_user->user_kana = $request->user_kana;
                $ec_user->email = $request->user_mail;
                if(isEmpty($request->user_password)){
                    $ec_user->password = password_hash($request->user_password, PASSWORD_DEFAULT);
                }
                $ec_user->admin_flg = $request->user_admin === 1 ? true : false;
                $ec_user->enable_flg = $request->user_enable === 1 ? true : false;
                $ec_user->last_login_at = null;
                $ec_user->email_verified_at = null;
                break;
        }
        // ユーザー登録
        $ec_user->save();
        // リダイレクト
        return redirect('/ec_site/users');
    }
}
