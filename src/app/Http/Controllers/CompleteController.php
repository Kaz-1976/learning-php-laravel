<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\EcCart;
use App\Models\EcCartDetail;

class CompleteController extends Controller
{
    public function index(Request $request)
    {
        // カート情報
        if (empty($request->cart_id)) {
            $ec_cart_details = null;
            $ec_cart_total = null;
        } else {
            // カート内合計の数量・価格を取得
            $ec_cart_total = DB::table('ec_cart_details')
                ->selectRaw('SUM(qty) as total_qty')
                ->selectRaw('SUM(price * qty) as total_price')
                ->where('cart_id', '=', $request->cart_id)
                ->get();
            // カート明細レコード取得
            $ec_cart_data = EcCart::query()
                ->with([
                    'ec_cart_details:cart_id,id,product_id,price,qty',
                    'ec_cart_details.ec_products:id,name,image_data,image_type,price,qty,public_flg'
                ])
                ->where('id', '=', $request->cart_id)
                ->where('checkout_flg', '=', 1)
                ->paginate(6);
        }
        //
        return view('ec_site.complete', ['ec_cart_data' => $ec_cart_data, 'ec_cart_total' => $ec_cart_total]);
    }
}
