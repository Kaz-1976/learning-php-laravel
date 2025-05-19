<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\EcAddress;
use App\Models\EcPref;
use App\Models\EcZip;
use App\Http\Requests\EcAddressRequest;

class MyAddressController extends Controller
{
    public function index()
    {
        // 都道府県マスタ取得
        $ecPrefs = EcPref::query()
            ->orderBy('code', 'asc')
            ->get();
        // 配送先情報取得
        $ecAddresses = EcAddress::query()
            ->where('user_id', '=', Auth::id())
            ->orderBy('id', 'asc')
            ->paginate(6);
        //
        return view(
            'ec_site.address',
            [
                'ecAddresses' => $ecAddresses,
                'prefs' => $ecPrefs->toArray(),
            ]
        );
    }

    public function store(EcAddressRequest $request)
    {
        // 検証済みデータ
        $valid_data = $request->safe();
        // DB処理
        try {
            // 配送先生成
            $ecAddress = new EcAddress();
            // 配送先設定
            $ecAddress->user_id = Auth::id();
            $ecAddress->name = $valid_data['name'];
            $ecAddress->zip = $valid_data['zip'];
            $ecAddress->pref = $valid_data['pref'];
            $ecAddress->address1 = mb_convert_kana($valid_data['address1'], 'ASKV');
            $ecAddress->address2 = mb_convert_kana($valid_data['address2'], 'ASKV');
            // 配送先登録
            $ecAddress->save();
            // メッセージ設定
            $result['message'] = '配送先の登録を完了しました。';
            // ステータス設定
            $result['status'] = true;
        } catch (\Exception $e) {
            // メッセージ設定
            $result['message'] = '配送先の登録に失敗しました。';
            // ステータス設定
            $result['status'] = false;
            // ログ出力
            Log::error($result['message']);
            Log::error($e);
        }
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

    public function update(EcAddressRequest $request)
    {
        // 検証済みデータ
        $valid_data = $request->safe();
        // 配送先取得
        $ecAddress = EcAddress::find($request->id);
        // 更新処理
        if ($ecAddress) {
            // メッセージ設定
            $result['message'] = '配送先が見つかりません。';
            // ステータス設定
            $result['status'] = false;
            // ログ出力
            Log::error($result['message']);
            Log::error('配送先ID： ' . $request->id);
        } else {
            try {
                // 配送先設定
                $ecAddress->user_id = Auth::id();
                $ecAddress->name = $valid_data['name'];
                $ecAddress->zip = $valid_data['zip'];
                $ecAddress->pref = $valid_data['pref'];
                $ecAddress->address1 = mb_convert_kana($valid_data['address1'], 'ASKV');
                $ecAddress->address2 = mb_convert_kana($valid_data['address2'], 'ASKV');
                // 配送先更新
                $ecAddress->save();
                // メッセージ設定
                $result['message'] = '配送先の更新を完了しました。';
                // ステータス設定
                $result['status'] = true;
            } catch (\Exception $e) {
                // メッセージ設定
                $result['message'] = '配送先の更新に失敗しました。';
                // ステータス設定
                $result['status'] = false;
                // ログ出力
                Log::error($result['message']);
                Log::error('配送先ID： ' . $request->id);
                Log::error($e);
            }
        }
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

    public function destroy(Request $request)
    {
        // 配送先取得
        $ecAddress = EcAddress::find($request->id);
        // 削除処理
        if ($ecAddress) {
            try {
                // 配送先削除
                $ecAddress->delete();
                // メッセージ設定
                $result['message'] = '配送先の削除を完了しました。';
                // ステータス設定
                $result['status'] = true;
            } catch (\Exception $e) {
                // メッセージ設定
                $result['message'] = '配送先の削除に失敗しました。';
                // ステータス設定
                $result['status'] = false;
                // ログ出力
                Log::error($result['message']);
                Log::error('配送先ID： ' . $request->id);
                Log::error($e);
            }
        } else {
            // メッセージ設定
            $result['message'] = '配送先が見つかりません。';
            // ステータス設定
            $result['status'] = false;
            // ログ出力
            Log::error($result['message']);
            Log::error('配送先ID： ' . $request->id);
        }
        // リダイレクト
        return redirect(url(null, null, app()->isProduction())->previous())
            ->with('message', $result['message']);
    }
}
