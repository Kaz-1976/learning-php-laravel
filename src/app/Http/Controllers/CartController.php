<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EcCartDetail;

class CartController extends Controller
{
    public function index()
    {
        // カート情報
        $ec_cart_detail = EcCartDetail::query()
            ->with('ec_products')
            ->where('ec_cart_detail.cart_id', '=', session()->get('cart-id'))
            ->where('ec_cart_detail.product_id', '=', 'ec_products.id')
            ->orderBy('ec_cart_detail.id')
            ->get();
        //
        return view('ec_site.cart', ['ec_cart_detail' => $ec_cart_detail]);
    }
}
