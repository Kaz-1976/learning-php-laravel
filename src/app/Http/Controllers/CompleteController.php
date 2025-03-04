<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\EcUser;
use App\Models\EcProduct;
use App\Models\EcAddress;
use App\Models\EcCart;
use App\Models\EcCartDetail;
use App\Models\EcReceipt;
use App\Models\EcReceiptDetail;

class CompleteController extends Controller
{
    public function index(Request $request)
    {
        // レシートID取得
        $receiptId = $request->session()->get('receipt_id');
        // レシート情報取得
        $ecReceipt = EcReceipt::find($receiptId);
        if (empty($ecReceipt)) {
            $ecReceiptDetails = null;
        } else {
            // カート明細レコード取得
            $ecReceiptDetails = EcReceiptDetail::query()
                ->where('receipt_id', '=', $receiptId)
                ->paginate(6);
        }
        //
        return view('ec_site.complete', ['ecReceipt' => $ecReceipt, 'ecReceiptDetaisl' => $ecReceiptDetails]);
    }

    public function store(Request $request)
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
                // 宛先情報取得
                $ecAddress = EcAddress::query()
                    ->with('ec_prefs')
                    ->where('id', '=', $request->id)
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
                $ecReceipt->zip = $ecAddress->zip;
                $ecReceipt->address1 = $ecAddress->ec_prefs->name . $ecAddress->address1;
                $ecReceipt->address2 = $ecAddress->address2;
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
                // レシートIDをセッション変数に保存
                $request->session()->flush('receipt_id', $ecReceipt->id);
                // セッションIDの再生成無効
                $request->session()->regenerate(false);
                // ユーザーに紐付くカートIDを空にする
                $ec_user = EcUser::find(Auth::id());
                $ec_user->cart_id = null;
                $ec_user->save();
                // カート明細情報削除
                EcCartDetail::query()
                    ->where('cart_id', '=', $cart_id)
                    ->delete();
                // カート情報削除
                EcCart::destroy($cart_id);
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
            // セッション変数破棄
            session()->forget('receipt_id');
            // リダイレクト
            return redirect(url('/cart', null, app()->isProduction()))
                ->with('message', '購入処理でエラーが発生しました。');
        }
        // リダイレクト
        return redirect(url('/complete', null, app()->isProduction()))
            ->with('message', 'ご利用ありがとうございました。');
    }
}
