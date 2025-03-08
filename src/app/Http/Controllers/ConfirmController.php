<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\EcUser;
use App\Models\EcProduct;
use App\Models\EcCart;
use App\Models\EcCartDetail;
use App\Models\EcReceipt;
use App\Models\EcReceiptDetail;

class ConfirmController extends Controller
{
    public function index(Request $request)
    {
        // カートID取得
        $id = Auth::user()->cart_id;
        // カート情報取得
        $ecCart = EcCart::query()
            ->with('ec_addresses.ec_prefs')
            ->where('id', '=', $id)
            ->first();
        if (empty($ecCart)) {
            $ecCartTotal = null;
            $ecCartDetails = null;
        } else {
            // カート内合計の数量・価格を取得
            $ecCartTotal = DB::table('ec_cart_details')
                ->selectRaw('SUM(qty) as total_qty')
                ->selectRaw('SUM(price * qty) as total_amount')
                ->where('cart_id', '=', $id)
                ->first();
            // カート明細レコード取得
            $ecCartDetails = EcCartDetail::query()
                ->with('ec_products')
                ->where('cart_id', '=', $id)
                ->paginate(6);
        }
        //
        return view('ec_site.confirm', ['ecCart' => $ecCart, 'ecCartDetails' => $ecCartDetails, 'ecCartTotal' => $ecCartTotal]);
    }
    public function store(Request $request)
    {
        try {
            // カートID取得
            $cart_id = Auth::user()->cart_id;
            // トランザクション開始
            DB::transaction(function () use ($cart_id,  $request) {
                // カート情報取得
                $ecCart = EcCart::query()
                    ->with('ec_addresses.ec_prefs')
                    ->where('id', '=', $cart_id)
                    ->first();
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
                        return redirect(url('/confirm', null, app()->isProduction()))
                            ->with('message', '商品が存在しません。 商品名： ' . (empty($ecCartDetail->ec_products) ? 'NULL' : $ecCartDetail->ec_products->name));
                    }
                    // 商品在庫チェック
                    if ($ecCartDetail->ec_products->qty < $ecCartDetail->qty) {
                        // ロールバック
                        DB::rollBack();
                        //
                        return redirect(url('/confirm', null, app()->isProduction()))
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
                $ecCartTotal = DB::table('ec_cart_details')
                    ->selectRaw('SUM(qty) as total_qty')
                    ->selectRaw('SUM(price * qty) as total_amount')
                    ->where('cart_id', '=', Auth::user()->cart_id)
                    ->first();
                // 注文日時取得
                $date = date_create();
                // 注文番号生成
                $no = 'EC-' . str_pad((string) Auth::id(), 8, '0', STR_PAD_LEFT) . '-' . date_format($date, 'YmdHisu');
                // レシート情報登録
                $ecReceipt = new EcReceipt();
                $ecReceipt->user_id = Auth::id();
                $ecReceipt->no = $no;
                $ecReceipt->date = $date;
                $ecReceipt->qty = $ecCartTotal->total_qty;
                $ecReceipt->amount = $ecCartTotal->total_amount;
                $ecReceipt->zip = $ecCart->ec_addresses->zip;
                $ecReceipt->address1 = $ecCart->ec_addresses->ec_prefs->name . $ecCart->ec_addresses->address1;
                $ecReceipt->address2 = $ecCart->ec_addresses->address2;
                $ecReceipt->save();
                // レシート明細情報登録
                foreach ($ecCartDetails as $ecCartDetail) {
                    $ecReceiptDetail = new EcReceiptDetail();
                    $ecReceiptDetail->receipt_id = $ecReceipt->id;
                    $ecReceiptDetail->name = $ecCartDetail->ec_products->name;
                    $ecReceiptDetail->image_type = $ecCartDetail->ec_products->image_type;
                    $ecReceiptDetail->image_data = $ecCartDetail->ec_products->image_data;
                    $ecReceiptDetail->price = $ecCartDetail->ec_products->price;
                    $ecReceiptDetail->qty = $ecCartDetail->qty;
                    $ecReceiptDetail->save();
                }
                // カート明細情報削除
                EcCartDetail::query()
                    ->where('cart_id', '=', $cart_id)
                    ->delete();
                // カート情報削除
                EcCart::destroy($cart_id);
                // ユーザー情報更新
                Auth::user()->refresh();
                // レシートIDをセッションに保存
                session()->put('receipt_id', $ecReceipt->id);
                // コミット
                DB::commit();
            });
        } catch (\Exception $e) {
            // ロールバック
            DB::rollBack();
            // ログ出力
            Log::error('購入処理に失敗しました。');
            Log::error('カートID： ' . $cart_id);
            Log::error($e);
            // リダイレクト
            return redirect(url('/confirm', null, app()->isProduction()))
                ->with('message', '購入処理でエラーが発生しました。');
        }
        // リダイレクト
        return redirect(url('/complete', null, app()->isProduction()))
            ->with('receipt_id', session()->get('receipt_id'))
            ->with('message', 'ご利用ありがとうございました。');
    }
}
