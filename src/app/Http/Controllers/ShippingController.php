<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\EcAddress;
use App\Models\EcPref;
use App\Models\EcCart;
use App\Http\Requests\EcAddressRequest;

class ShippingController extends Controller
{
    public function index()
    {
        // 宛先情報取得
        $ecAddresses = EcAddress::query()
            ->with('ec_prefs')
            ->where('user_id', '=', Auth::id())
            ->orderBy('id', 'asc')
            ->get();
        // 都道府県マスタ取得
        $ecPrefs = EcPref::query()
            ->orderBy('code', 'asc')
            ->get();
        // ビューを返す
        return view(
            'ec_site.shipping',
            [
                'ecAddresses' => $ecAddresses,
                'prefs' => $ecPrefs->toArray()
            ]
        );
    }

    public function store(Request $request)
    {
        // トランザクション開始
        $result = DB::transaction(function () use ($request) {
            try {
                // カート情報更新
                if ($request->id === '0') {
                    // 検証済データ取得
                    $ecAddressRequest = new EcAddressRequest();
                    $ecAddressRequestRules = $ecAddressRequest->rules();
                    $valid_data = $request->validate($ecAddressRequestRules);
                    // 配送先情報生成
                    $ecAddress = new EcAddress();
                    // 配送先情報登録
                    $ecAddress->user_id = Auth::id();
                    $ecAddress->name = $valid_data['name'];
                    $ecAddress->zip = $valid_data['zip'];
                    $ecAddress->pref = $valid_data['pref'];
                    $ecAddress->address1 = mb_convert_kana($valid_data['address1'], 'ASKV');
                    $ecAddress->address2 = mb_convert_kana($valid_data['address2'], 'ASKV');
                    $ecAddress->save();
                    // 配送先ID設定
                    $id = $ecAddress->id;
                    // メッセージ設定
                    $result['message'] = '配送先情報を登録しました。';
                } else {
                    $id = $request->id;
                    // メッセージ設定
                    $result['message'] = '';
                }
                // カート情報更新
                $cart = EcCart::find(Auth::user()->cart_id);
                $cart->address_id = $id;
                $cart->save();
                // ステータス設定
                $result['status'] = true;
            } catch (\Exception $e) {
                // メッセージ設定
                $result['message'] = '配送先情報の登録に失敗しました。';
                // ステータス設定
                $result['status'] = false;
                // ログ出力
                Log::error($result['message']);
                Log::error($e);
            }
            // リターン
            return $result;
        });
        // リダイレクト
        if ($result['status']) {
            return redirect(url('confirm', null, app()->isProduction()))
                ->with('message', $result['message']);
        } else {
            return redirect(url('shipping', null, app()->isProduction()))
                ->withInput($request->except('password'))
                ->with('message', $result['message']);
        }
    }
}
