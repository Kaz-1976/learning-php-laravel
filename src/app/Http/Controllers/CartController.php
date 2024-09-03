<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EcCartDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        // カート情報
        if (empty(Auth::user()->cart_id)) {
            $ec_cart_details = null;
            $ec_cart_total = null;
        } else {
            // カート明細レコード取得
            $ec_cart_details = EcCartDetail::query()
                ->with(['ec_products:id,name,image_data,image_type,qty,price'])
                ->find(Auth::user()->cart_id)
                ->orderBy('id', 'asc')
                ->paginate(6);
            // カート内合計の数量・価格を取得
            $ec_cart_total = DB::table('ec_cart_details')
                ->selectRaw('SUM(qty) as total_qty')
                ->selectRaw('SUM(price * qty) as total_price')
                ->where('cart_id', '=', Auth::user()->cart_id)
                ->get();
        }
        //
        return view('ec_site.cart', ['ec_cart_details' => $ec_cart_details, 'ec_cart_total' => $ec_cart_total[0]]);
    }

    public function update(Request $request) {}

    public function delete(Request $request) {}

    public function clear(Request $request) {}

    public function checkout(Request $request) {}
}
