<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EcUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EcUserUpdateRequest;

class MyProfileController extends Controller
{
    public function index()
    {
        //
        $ec_user = EcUser::query()->find(Auth::id());
        //
        return view('ec_site.profile', ['ec_user' => $ec_user]);
    }

    // ユーザー更新
    public function update(EcUserUpdateRequest $request)
    {
        // セッションIDの再生成無効
        $request->session()->regenerate(false);
        // 検証済みデータ
        $valid_data = $request->safe();
        // ユーザーレコード取得
        $ecUser = EcUser::find(Auth::id());
        if ($ecUser) {
            // メッセージ設定
            $result['message'] = 'ユーザーが見つかりません。';
            // ステータス設定
            $result['status'] = false;
            // ログ出力
            Log::error($result['message']);
            Log::error('ユーザーID： ' . $ecUser->user_id);
        } else {
            try {
                // ユーザーレコード設定
                $ecUser->user_name = $valid_data->user_id;
                $ecUser->user_name = $valid_data->user_name;
                $ecUser->user_kana = $valid_data->user_kana;
                $ecUser->email = $valid_data->email;
                // パスワード設定
                if (!empty($request->safe()->only(['password']))) {
                    $ecUser->password = Hash::make($valid_data->password);
                }
                // 保存
                $ecUser->save();
                // メッセージ設定
                $result['message'] = 'ユーザー情報を更新しました。';
                // ステータス設定
                $result['status'] = true;
            } catch (\Exception $e) {
                // メッセージ設定
                $result['message'] = 'ユーザー情報の更新に失敗しました。';
                // ステータス設定
                $result['status'] = false;
                // ログ出力
                Log::error($result['message']);
                Log::error('ユーザーID： ' . $ecUser->user_id);
                Log::error($e);
            }
        }
        // セッションID再生成有効
        $request->session()->regenerate(true);
        // リダイレクト
        if ($result['status']) {
            return redirect(url(null, null, app()->isProduction())->previous())
                ->with('message', $result['message']);
        } else {
            return redirect(url(null, null, app()->isProduction())->previous())
                ->withInput($request->except('password'))
                ->with('message', $result['message']);
        }
    }
}
