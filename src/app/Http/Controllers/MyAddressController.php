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
        // 宛先情報取得
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
        // 宛先生成
        $ecAddress = new EcAddress();
        try {
            // 宛先設定
            $ecAddress->user_id = Auth::id();
            $ecAddress->name = $valid_data['name'];
            $ecAddress->zip = $valid_data['zip'];
            $ecAddress->pref = $valid_data['pref'];
            $ecAddress->address1 = mb_convert_kana($valid_data['address1'], 'ASKV');
            $ecAddress->address2 = mb_convert_kana($valid_data['address2'], 'ASKV');
            // 宛先登録
            $ecAddress->save();
            // メッセージ設定
            $message = '宛先の登録を完了しました。';
        } catch (\Exception $e) {
            // ログ出力
            Log::error('宛先の登録に失敗しました。');
            Log::error($e);
            // メッセージ設定
            $message = '宛先の登録に失敗しました。';
        }
        // リダイレクト
        return redirect(url(null, null, app()->isProduction())->previous())
            ->with('message', $message);
    }

    public function update(EcAddressRequest $request)
    {
        // 検証済みデータ
        $valid_data = $request->safe();
        // 宛先取得
        $ecAddress = EcAddress::find($request->id);
        // 更新処理
        if ($ecAddress) {
            try {
                // 宛先設定
                $ecAddress->user_id = Auth::id();
                $ecAddress->name = $valid_data['name'];
                $ecAddress->zip = $valid_data['zip'];
                $ecAddress->pref = $valid_data['pref'];
                $ecAddress->address1 = mb_convert_kana($valid_data['address1'], 'ASKV');
                $ecAddress->address2 = mb_convert_kana($valid_data['address2'], 'ASKV');
                // 宛先更新
                $ecAddress->save();
                // メッセージ設定
                $message = '宛先の更新を完了しました。';
            } catch (\Exception $e) {
                // ログ出力
                Log::error('宛先の更新に失敗しました。');
                Log::error($e);
                // メッセージ設定
                $message = '宛先の更新に失敗しました。';
            }
        } else {
            // メッセージ設定
            $message = '宛先が見つかりません。';
        }
        // リダイレクト
        return redirect(url(null, null, app()->isProduction())->previous())
            ->with('message', $message);
    }

    public function destroy(Request $request)
    {
        // リクエストデータ取得
        $id = $request->id;
        // 宛先取得
        $ecAddress = EcAddress::find($id);
        // 削除処理
        if ($ecAddress) {
            try {
                // 宛先削除
                $ecAddress->delete();
                // メッセージ設定
                $message = '宛先の削除を完了しました。';
            } catch (\Exception $e) {
                // ログ出力
                Log::error('宛先の削除に失敗しました。');
                Log::error($e);
                // メッセージ設定
                $message = '宛先の削除に失敗しました。';
            }
        } else {
            // メッセージ設定
            $message = '宛先が見つかりません。';
        }
        // リダイレクト
        return redirect(url(null, null, app()->isProduction())->previous())
            ->with('message', $message);
    }
}
