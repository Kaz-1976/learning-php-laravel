<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\EcUser;

use function PHPUnit\Framework\isEmpty;

class EcUserController extends Controller
{

    protected $fillable = [
        'user_id',
        'user_name',
        'user_kana',
        'email',
        'password',
        'enable_flg',
        'admin_flg',
    ];

    // ログインしてなければログインページへ
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 一覧表示
    public function index()
    {
        //
        $ec_users = EcUser::all();
        //
        return view('ec_site.users', ['ec_users' => $ec_users]);
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
        $ec_user->email = $request->email;
        $ec_user->password = Hash::make($request->password);
        $ec_user->enable_flg = is_integer($request->enable_flg) ? $request->enable_flg : ($request->enable_flg == 'on' ? 1 : 0);
        $ec_user->admin_flg = is_integer($request->admin_flg) ? $request->admin_flg : ($request->admin_flg == 'on' ? 1 : 0);

        // ユーザー登録
        $ec_user->save();

        //
        return redirect(route('users.index'));
    }

    // ユーザー更新
    public function update(Request $request)
    {
        // ユーザーレコード取得
        $ec_user = EcUser::find($request->id);
        // フラグ設定
        switch (true) {
            case $request->has('enable'):
                $ec_user->enable_flg = $ec_user->enable_flg == 1 ? 0 : 1;
                $ec_user->update();
                break;
            case $request->has('admin'):
                $ec_user->admin_flg = $ec_user->admin_flg == 1 ? 0 : 1;
                $ec_user->update();
                break;
            case $request->has('update'):
                // ユーザーレコード設定
                $ec_user->user_id = $request->user_id;
                $ec_user->user_name = $request->user_name;
                $ec_user->user_kana = $request->user_kana;
                $ec_user->email = $request->email;
                // パスワード設定
                if (!isEmpty($request->password)) {
                    $ec_user->password = Hash::make($request->password);
                }
                // フラグ設定
                $ec_user->enable_flg = $request->enable_flg;
                $ec_user->admin_flg = $request->admin_flg;
                $ec_user->save();
                break;
        }

        //
        return redirect(route('users.index'));
    }
}
