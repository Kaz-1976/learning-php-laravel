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

    public function store(EcAddressRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // カートID取得
                $cart_id = Auth::user()->cart_id;
                // カート情報取得
                $cart = EcCart::find($cart_id);
                // カート情報更新
                if ($request->id == 0) {
                    // 検証済データ取得
                    $valid_data = $request->safe();
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
                } else {
                    $id = $request->id;
                }
                // カート情報更新
                $cart->address_id = $id;
                $cart->save();
                // コミット
                DB::commit();
            });
        } catch (\Exception $e) {
            // ロールバック
            DB::rollBack();
            // ログ出力
            Log::error('配送先情報の登録に失敗しました。');
            Log::error($e);
            // メッセージ設定
            $message = '配送先情報の登録に失敗しました。';
            // リダイレクト
            return redirect(url(null, null, app()->isProduction())->previous())
                ->with('message', $message);
        }
        // リダイレクト
        return redirect(url('confirm', null, app()->isProduction()));
    }
}
