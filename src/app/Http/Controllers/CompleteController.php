<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\EcCart;
use App\Models\EcCartDetail;

class CompleteController extends Controller
{
    public function index(Request $request)
    {
        // カート情報
        if (empty($request->session()->get('cart_id'))) {
            $ecCartDetails = null;
            $ecCartTotal = null;
        } else {
            // カートID取得
            $cartId = $request->session()->get('cart_id');
            // カートチェック
            $ecCart = EcCart::find($cartId);
            if ($ecCart->checkout_flg != 1) {
                $ecCartDetails = null;
                $ecCartTotal = null;
            } else {
                // カート内合計の数量・価格を取得
                $ecCartTotal = DB::table('ec_cart_details')
                    ->selectRaw('SUM(qty) as total_qty')
                    ->selectRaw('SUM(price * qty) as total_price')
                    ->where('cart_id', '=', $cartId)
                    ->first();
                // カート明細レコード取得
                $ecCartDetails = EcCartDetail::query()
                    ->with('ec_products:id,name,image_data,image_type,price,qty,public_flg')
                    ->where('cart_id', '=', $cartId)
                    ->paginate(6);
                //
                session()->flash('cart_id', $cartId);
            }
        }
        //
        return view('ec_site.complete', ['ecCartDetails' => $ecCartDetails, 'ecCartTotal' => $ecCartTotal]);
    }
}
