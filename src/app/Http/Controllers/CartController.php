<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\EcUser;
use App\Models\EcCart;
use App\Models\EcCartDetail;
use App\Http\Requests\EcCartDetailUpdateRequest;
use App\Http\Requests\EcCartStoreRequest;

class CartController extends Controller
{
    public function index()
    {
        // カート情報
        if (empty(Auth::user()->cart_id)) {
            $ecCartDetails = null;
            $ecCartTotal = null;
        } else {
            // カートチェック
            $ecCart = EcCart::find(Auth::user()->cart_id);
            if ($ecCart->checkout_flg != 0) {
                $ecCartDetails = null;
                $ecCartTotal = null;
            } else {
                // カート内合計の数量・価格を取得
                $ecCartTotal = DB::table('ec_cart_details')
                    ->selectRaw('SUM(qty) as total_qty')
                    ->selectRaw('SUM(price * qty) as total_amount')
                    ->where('cart_id', '=', Auth::user()->cart_id)
                    ->first();
                // カート明細レコード取得
                if ($ecCartTotal->total_qty == 0) {
                    $ecCartDetails = null;
                } else {
                    $ecCartDetails = EcCartDetail::query()
                        ->with([
                            'ec_products:id,name,image_data,image_type,price,qty,public_flg'
                        ])
                        ->where('cart_id', '=', Auth::user()->cart_id)
                        ->paginate(6);
                }
            }
        }
        //
        return view('ec_site.cart', ['ecCartDetails' => $ecCartDetails, 'ecCartTotal' => $ecCartTotal]);
    }

    public function store(EcCartStoreRequest $request)
    {
        // ポストデータ取得
        $order = $request->safe();
        // トランザクション
        try {
            $result = DB::transaction(function () use ($order, $request) {
                // カートID取得
                if (empty(Auth::user()->cart_id)) {
                    // カートを生成する
                    $ecCart = new EcCart();
                    $ecCart->user_id = Auth::id();
                    $ecCart->save();
                    // カートIDをユーザーテーブルに保存
                    $ecUser = EcUser::find(Auth::id());
                    $ecUser->cart_id = $ecCart->id;
                    $ecUser->save();
                    // ユーザー情報更新
                    Auth::setUser($ecUser);
                    $ecCartId = $ecCart->id;
                } else {
                    // カートレコード取得
                    $ecCart = EcCart::query()
                        ->where('id', '=', Auth::user()->cart_id)
                        ->get();
                    // カートID
                    $ecCartId = Auth::user()->cart_id;
                }
                // カート明細取得・生成
                $ecCartDetail = EcCartDetail::query()
                    ->where('cart_id', '=', $ecCartId)
                    ->where('product_id', '=', $request->id)
                    ->first();
                if (empty($ecCartDetail)) {
                    $ecCartDetail = new EcCartDetail();
                }
                // カート明細更新
                $ecCartDetail->price = $request->order_price;
                $ecCartDetail->qty += $order->order_qty;
                $ecCartDetail->cart_id = $ecCartId;
                $ecCartDetail->product_id = $request->id;
                $ecCartDetail->save();
                // メッセージ設定
                $result['message'] = '商品をカートに登録しました。 商品名： ' . $request->name . '　数量： ' . $order->order_qty . '点';
                // ステータス設定
                $result['status'] = true;
                // リターン
                return $result;
            });
        } catch (\Exception $e) {
            // メッセージ設定
            $result['message'] = '商品のカートへの登録に失敗しました。';
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

    public function update(EcCartDetailUpdateRequest $request)
    {
        // 検証済みデータ
        $valid_data = $request->safe();
        // 明細ID
        $id = $request->id;
        // 明細レコード取得
        $ecCartDetail = EcCartDetail::find($id);
        // DB処理
        if (empty($ecCartDetail)) {
            // メッセージ設定
            $result['message'] = 'カートに商品が見つかりません。商品名： ' . $request->name;
            // ステータス設定
            $result['status'] = false;
            // ログ出力
            Log::error($result['message']);
        } else {
            try {
                // 明細レコード更新
                $ecCartDetail->price = $request->price;
                $ecCartDetail->qty = $valid_data->qty;
                $ecCartDetail->save();
                // メッセージ設定
                $result['message'] = ' 注文数量を更新しました。商品名： ' . $request->name . ' ／ 数量： ' . $valid_data->qty;
                // ステータス設定
                $result['status'] = true;
            } catch (\Exception $e) {
                // メッセージ設定
                $result['message'] = '商品の注文数量の更新に失敗しました。';
                // ステータス設定
                $result['status'] = false;
                // ログ出力
                Log::error('商品の注文数量の更新に失敗しました。');
                Log::error($e);
            }
        }
        // リダイレクト
        if ($result['status']) {
            return redirect(url('cart', null, app()->isProduction()))
                ->with('message', $result['message']);
        } else {
            return redirect(url('cart', null, app()->isProduction()))
                ->withInput($request->except('password'))
                ->with('message', $result['message']);
        }
    }

    public function delete(Request $request)
    {
        // 明細ID
        $id = $request->id;
        // DB処理
        try {
            // 明細レコード取得
            EcCartDetail::find($id)
                ->delete();
            // メッセージ設定
            $result['message'] = '商品をカートから削除しました。商品名： ' . $request->name;
            // ステータス設定
            $result['status'] = true;
        } catch (\Exception $e) {
            // メッセージ設定
            $result['message'] = '商品をカートから削除に失敗しました。';
            // ステータス設定
            $result['status'] = false;
            // ログ出力
            Log::error($result['message']);
            Log::error($e);
        }
        // リダイレクト
        if ($result['status']) {
            return redirect(url('cart', null, app()->isProduction()))
                ->with('message', $result['message']);
        } else {
            return redirect(url('cart', null, app()->isProduction()))
                ->withInput($request->except('password'))
                ->with('message', $result['message']);
        }
    }

    public function clear(Request $request)
    {
        // カートID
        $id = Auth::user()->cart_id;
        // DB処理
        try {
            // カートIDに紐付くカート明細レコード削除
            EcCartDetail::query()
                ->where('cart_id', $id)
                ->delete();
            // メッセージ設定
            $result['message'] = 'ショッピングカートを空にしました。';
            // ステータス設定
            $result['status'] = true;
        } catch (\Exception $e) {
            // メッセージ設定
            $result['message'] = 'ショッピングカートを空にすることができませんでした。';
            // ステータス設定
            $result['status'] = false;
            // ログ出力
            Log::error($result['message']);
            Log::error($e);
        }
        // リダイレクト
        if ($result['status']) {
            return redirect(url('cart', null, app()->isProduction()))
                ->with('message', $result['message']);
        } else {
            return redirect(url('cart', null, app()->isProduction()))
                ->withInput($request->except('password'))
                ->with('message', $result['message']);
        }
    }
}
