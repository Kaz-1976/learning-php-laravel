<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\EcCart;
use App\Models\EcCartDetail;
use App\Http\Requests\EcCartDetailUpdateRequest;

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
        return redirect(url('/cart', null, app()->isProduction()))
            ->with('message', 'ショッピングカートを空にしました。');
    }
}
