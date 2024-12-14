<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\EcCart;
use App\Models\EcCartDetail;
use App\Models\EcProduct;
use App\Models\EcUser;
use App\Http\Requests\EcCartDetailUpdateRequest;
use App\Helpers\UrlHelper;

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
                $ecCartTotal = DB::table('ecCartDetails')
                    ->selectRaw('SUM(qty) as total_qty')
                    ->selectRaw('SUM(price * qty) as total_price')
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

    public function update(EcCartDetailUpdateRequest $request)
    {
        // 検証済みデータ
        $valid_data = $request->safe();
        // 明細ID
        $id = $request->id;
        // 明細レコード取得
        $ecCartDetail = EcCartDetail::find($id);
        // 明細レコード更新
        $ecCartDetail->price = $request->price;
        $ecCartDetail->qty = $valid_data->qty;
        $ecCartDetail->save();
        //
        return redirect(url(null, null, app()->isProduction())->previous())
            ->with('message', '商品名： ' . $request->name . ' の注文数量を更新しました。');
    }

    public function delete(Request $request)
    {
        // 明細ID
        $id = $request->id;
        // 明細レコード取得
        EcCartDetail::find($id)
            ->delete();
        //
        return redirect(url(null, null, app()->isProduction())->previous())
            ->with('message', '商品名： ' . $request->name . ' をカートから削除しました。');
    }

    public function clear(Request $request)
    {
        // カートID
        $id = Auth::user()->cart_id;
        // カートIDに紐付くカート明細レコード削除
        EcCartDetail::query()
            ->where('cart_id', $id)
            ->delete();
        //
        return redirect(UrlHelper::generateUrl('cart'))
            ->with('message', 'ショッピングカートを空にしました。');
    }

    public function checkout(Request $request)
    {
        // カートID取得
        $cart_id = Auth::user()->cart_id;
        // トランザクション開始
        try {
            DB::transaction(function () use ($cart_id,  $request) {
                // カート情報取得
                $ecCart = EcCart::find($cart_id);
                if ($ecCart->checkout_flg != 0) {
                    // ロールバック
                    DB::rollBack();
                    // ログ出力
                    Log::error('購入処理に失敗しました。');
                    Log::error('そのカートは決済済みです。');
                    Log::error('カートID： ' . $cart_id);
                    // リターン
                    return redirect(url(null, null, app()->isProduction())->previous())
                        ->with('message', '購入処理に失敗しました。');
                }
                // カート明細取得
                $ecCartDetails = EcCartDetail::query()
                    ->with([
                        'ec_products:id,name,image_data,image_type,price,qty,public_flg'
                    ])
                    ->where('cart_id', '=', $cart_id)
                    ->get();
                // 在庫引当処理
                foreach ($ecCartDetails as $ecCartDetail) {
                    // 商品存在チェック
                    if (empty($ecCartDetail->ec_products) || $ecCartDetail->ec_products->public_flg == 0) {
                        // ロールバック
                        DB::rollBack();
                        //
                        return redirect(url(null, null, app()->isProduction())->previous())
                            ->with('message', '商品が存在しません。 商品名： ' . (empty($ecCartDetail->ec_products) ? 'NULL' : $ecCartDetail->ec_products->name));
                    }
                    // 商品在庫チェック
                    if ($ecCartDetail->ec_products->qty < $ecCartDetail->qty) {
                        // ロールバック
                        DB::rollBack();
                        //
                        return redirect(url(null, null, app()->isProduction())->previous())
                            ->with('message', '注文数量に対して在庫が不足しています。 商品名： ' . $ecCartDetail->ec_products->name . ' 在庫数： ' . $ecCartDetail->ec_products->qty);
                    }
                    // 商品レコード取得
                    $ec_product = EcProduct::find($ecCartDetail->product_id);
                    // 在庫更新
                    $ec_product->decrement('qty', $ecCartDetail->qty);
                    $ec_product->save();
                }
                // 決済処理

                // TODO: 実際の決済処理

                // カート内合計取得
                $ecCartTotal = DB::table('ecCartDetails')
                    ->selectRaw('SUM(qty) as total_qty')
                    ->selectRaw('SUM(price * qty) as total_price')
                    ->where('cart_id', '=', Auth::user()->cart_id)
                    ->first();
                // カート情報更新
                $ecCart = EcCart::find($cart_id);
                $ecCart->checkout_flg = 1;
                $ecCart->checkout_qty = $ecCartTotal->total_qty;
                $ecCart->checkout_price = $ecCartTotal->total_price;
                $ecCart->save();
                // セッションIDの再生成無効
                $request->session()->regenerate(false);
                // ユーザーに紐付くカートIDを空にする
                $ec_user = EcUser::find(Auth::id());
                $ec_user->cart_id = null;
                $ec_user->save();
                // コミット
                DB::commit();
                // ユーザー情報更新
                Auth::user()->refresh();
                // セッションID再生成有効
                $request->session()->regenerate(true);
            });
        } catch (\Exception $e) {
            // ロールバック
            DB::rollBack();
            // ログ出力
            Log::error('購入処理に失敗しました。');
            Log::error('カートID： ' . $cart_id);
            Log::error($e);
            //
            return redirect(url()->previous())
                ->with('message', '購入処理でエラーが発生しました。');
        }
        // セッション変数にカートIDを保存
        session()->flash('cart_id', $cart_id);
        // リダイレクト
        return redirect(UrlHelper::generateUrl('ec_site/complete'))
            ->with('message', 'ご利用ありがとうございました。');
    }
}
