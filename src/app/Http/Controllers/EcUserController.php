<?php

namespace App\Http\Controllers;

use App\Models\EcUser;
use App\Http\Requests\EcUserCreateRequest;
use App\Http\Requests\EcUserUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

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
        'last_login_at',
        'email_verified_at',
    ];

    // 一覧表示
    public function index()
    {
        //
        $ec_users = EcUser::orderBy('id','asc')->paginate(5);
        //
        return view('ec_site.users', ['ec_users' => $ec_users]);
    }

    // ユーザー登録
    public function store(EcUserCreateRequest $request)
    {
        // 検証済みデータ
        $valid_data = $request->safe();

        // ユーザー生成
        $ec_user = new EcUser();

        // ユーザー設定
        $ec_user->user_id = $valid_data->user_id;
        $ec_user->user_name = $valid_data->user_name;
        $ec_user->user_kana = $valid_data->user_kana;
        $ec_user->email = $valid_data->email;
        $ec_user->password = Hash::make($valid_data->password);
        $ec_user->enable_flg = $request->enable_flg == 'on' ? true : false;
        $ec_user->admin_flg = $request->admin_flg == 'on' ? true : false;

        // ユーザー登録
        $ec_user->save();

        //
        return redirect(route('users.index'));
    }

    // ユーザー更新
    public function update(EcUserUpdateRequest $request)
    {
        // 検証済みデータ
        $valid_data = $request->safe();

        // ユーザーレコード取得
        $ec_user = EcUser::find($request->id);

        // フラグ設定
        switch (true) {
            case $request->has('enable'):
                // 有効フラグ更新
                $ec_user->enable_flg = $ec_user->enable_flg == 1 ? 0 : 1;
                // 保存
                $ec_user->update();
                break;
            case $request->has('admin'):
                // 管理者フラグ更新
                $ec_user->admin_flg = $ec_user->admin_flg == 1 ? 0 : 1;
                // 保存
                $ec_user->update();
                break;
            case $request->has('update'):
                // ユーザーレコード設定
                $ec_user->user_id = $valid_data->user_id;
                $ec_user->user_name = $valid_data->user_name;
                $ec_user->user_kana = $valid_data->user_kana;
                $ec_user->email = $valid_data->email;

                // パスワード設定
                if (!isEmpty($request->safe()->only(['password']))) {
                    $ec_user->password = Hash::make($valid_data->password);
                }

                // フラグ設定
                $ec_user->enable_flg = $request->enable_flg;
                $ec_user->admin_flg = $request->admin_flg;

                // 保存
                $ec_user->save();
                break;
        }

        //
        return redirect(route('users.index'));
    }
}
