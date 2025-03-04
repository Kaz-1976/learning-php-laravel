<?php

namespace App\Http\Controllers;

use App\Models\EcUser;
use App\Http\Requests\EcUserCreateRequest;
use App\Http\Requests\EcUserUpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
        $ecUsers = EcUser::orderBy('id', 'asc')->paginate(6);
        //
        return view('ec_site.users', ['ecUsers' => $ecUsers]);
    }

    // ユーザー登録
    public function store(EcUserCreateRequest $request)
    {
        // 検証済みデータ
        $valid_data = $request->safe();

        try {
            // ユーザー生成
            $ecUser = new EcUser();
            // ユーザー設定
            $ecUser->user_id = $valid_data->user_id;
            $ecUser->user_name = $valid_data->user_name;
            $ecUser->user_kana = $valid_data->user_kana;
            $ecUser->email = $valid_data->email;
            $ecUser->password = Hash::make($valid_data->password);
            $ecUser->enable_flg = $request->enable_flg == 'on' ? true : false;
            $ecUser->admin_flg = $request->admin_flg == 'on' ? true : false;
            // ユーザー登録
            $ecUser->save();
            // メッセージ設定
            $message = 'ユーザーの登録を完了しました。';
        } catch (\Exception $e) {
            // ログ出力
            Log::error('ユーザーの登録に失敗しました。');
            Log::error($e);
            // メッセージ設定
            $message = 'ユーザーの登録に失敗しました。';
        }
        // リターン
        return redirect(url(null, null, app()->isProduction())->previous())->with('message', $message);
    }

    // ユーザー更新
    public function update(EcUserUpdateRequest $request)
    {
        // セッションIDの再生成無効
        $request->session()->regenerate(false);
        // 検証済みデータ
        $valid_data = $request->safe();
        //
        switch (true) {
            case $request->has('enable'):
                $message = DB::transaction(function () use ($request, $valid_data) {
                    try {
                        // ユーザーレコード取得
                        $ecUser = EcUser::find($request->id);
                        // 有効フラグ更新
                        $ecUser->enable_flg = $request->enable_flg == 1 ? 0 : 1;
                        // 保存
                        $ecUser->save();
                        // コミット
                        DB::commit();
                    } catch (\Exception $e) {
                        // ロールバック
                        DB::rollBack();
                        // ログ出力
                        Log::error('ユーザーの' . ($request->enable_flg == 1 ? '無効' : '有効') . '化に失敗しました。');
                        Log::error('ユーザーID： ' . $request->user_id);
                        Log::error($e);
                        // メッセージ設定
                        $message = 'ユーザーの' . ($request->enable_flg == 1 ? '無効' : '有効') . '化に失敗しました。ユーザーID： ' . $ecUser->user_id;
                        return;
                    }
                    // メッセージ設定
                    $message = 'ユーザーを' . ($request->enable_flg == 1 ? '無効' : '有効') . '化しました。ユーザーID： ' . $ecUser->user_id;
                    // リターン
                    return $message;
                });
                break;
            case $request->has('admin'):
                $message = DB::transaction(function () use ($request, $valid_data) {
                    try {
                        // ユーザーレコード取得
                        $ecUser = EcUser::find($request->id);
                        // 管理者フラグ更新
                        $ecUser->admin_flg = $request->admin_flg == 1 ? 0 : 1;
                        // 保存
                        $ecUser->save();
                        // コミット
                        DB::commit();
                    } catch (\Exception $e) {
                        // ロールバック
                        DB::rollBack();
                        // ログ出力
                        Log::error('ユーザーを' . ($request->admin_flg == 1 ? '一般ユーザー' : '管理者') . 'への変更に失敗しました。');
                        Log::error('ユーザーID： ' . $request->user_id);
                        Log::error($e);
                        // メッセージ設定
                        $message = 'ユーザーの' . ($request->admin_flg == 1 ? '一般ユーザー' : '管理者') . 'への変更に失敗しました。ユーザーID： ' . $ecUser->user_id;
                        return;
                    }
                    // メッセージ設定
                    $message = 'ユーザーを' . ($request->admin_flg == 1 ? '一般ユーザー' : '管理者') . 'へ変更しました。ユーザーID： ' . $ecUser->user_id;
                    // リターン
                    return $message;
                });
                break;
            case $request->has('update'):
                $message = DB::transaction(function () use ($request, $valid_data) {
                    try {
                        // ユーザーレコード取得
                        $ecUser = EcUser::find($request->id);
                        // ユーザーID設定
                        if ($ecUser->user_id != $valid_data->user_id) {
                            $ecUser->user_id = $valid_data->user_id;
                        }
                        // パスワード設定
                        if (!empty($request->safe()->only(['password']))) {
                            $ecUser->password = Hash::make($valid_data->password);
                        }
                        // ユーザーレコード設定
                        $ecUser->user_name = $valid_data->user_name;
                        $ecUser->user_kana = $valid_data->user_kana;
                        $ecUser->email = $valid_data->email;
                        // フラグ設定
                        $ecUser->enable_flg = $request->enable_flg;
                        $ecUser->admin_flg = $request->admin_flg;
                        // 保存
                        $ecUser->save();
                        // コミット
                        DB::commit();
                    } catch (\Exception $e) {
                        // ロールバック
                        DB::rollBack();
                        // ログ出力
                        Log::error('ユーザー情報の更新に失敗しました。');
                        Log::error('ユーザーID： ' . $ecUser->user_id);
                        Log::error($e);
                        // メッセージ設定
                        $message = 'ユーザー情報の更新に失敗しました。ユーザーID： ' . $ecUser->user_id;
                    }
                    // メッセージ設定
                    $message = 'ユーザー情報を更新しました。ユーザーID： ' . $ecUser->user_id;
                    // リターン
                    return $message;
                });
                break;
        }
        // セッションID再生成有効
        $request->session()->regenerate(true);
        // リターン
        return redirect(url(null, null, app()->isProduction())->previous())
            ->with('message', $message);
    }
}
