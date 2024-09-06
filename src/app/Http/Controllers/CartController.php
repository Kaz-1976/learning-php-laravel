<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\EcCartDetail;
use App\Http\Requests\EcCartDetailUpdateRequest;

class CartController extends Controller
{
    public function index()
    {
        // カート情報
        if (empty(Auth::user()->cart_id)) {
            $ec_cart_details = null;
            $ec_cart_total = null;
        } else {
            // カート内合計の数量・価格を取得
            $ec_cart_total = DB::table('ec_cart_details')
                ->selectRaw('SUM(qty) as total_qty')
                ->selectRaw('SUM(price * qty) as total_price')
                ->where('cart_id', '=', Auth::user()->cart_id)
                ->get();
            // カート明細レコード取得
            if ($ec_cart_total[0]->total_qty == 0) {
                $ec_cart_details = null;
            } else {
                $ec_cart_details = EcCartDetail::query()
                    ->with(['ec_products:id,name,image_data,image_type,qty,price'])
                    ->find(Auth::user()->cart_id)
                    ->orderBy('id', 'asc')
                    ->paginate(6);
            }
        }
        //
        return view('ec_site.cart', ['ec_cart_details' => $ec_cart_details, 'ec_cart_total' => $ec_cart_total[0]]);
    }

    public function update(EcCartDetailUpdateRequest $request)
    {
        // 検証済みデータ
        $valid_data = $request->safe();
        // 明細ID
        $id = $request->id;
    }

    public function delete(Request $request)
    {
        // 明細ID
        $id = $request->id;
        // レコード削除
        EcCartDetail::query()
            ->where('id', $id)
            ->delete();
        //
        return redirect(route('cart.index'));
    }

    public function clear(Request $request)
    {
        // カートID
        $id = Auth::user()->cart_id;
        // レコード削除
        EcCartDetail::query()
            ->where('cart_id', $id)
            ->delete();
        //
        return redirect(route('cart.index'));
    }
}
