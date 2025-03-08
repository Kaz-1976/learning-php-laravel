<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EcAddress;
use App\Models\EcCart;

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
        // ビューを返す
        return view(
            'ec_site.shipping',
            [
                'ecAddresses' => $ecAddresses
            ]
        );
    }

    public function store(Request $request)
    {
        // カートID取得
        $cart_id = Auth::user()->cart_id;
        // カート情報取得
        $cart = EcCart::find($cart_id);
        // カート情報更新
        $cart->address_id = $request->id;
        $cart->save();
        // リダイレクト
        return redirect(url('confirm', null, app()->isProduction()));
    }
}
