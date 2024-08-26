<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EcCartDetail;

class CartController extends Controller
{
    public function index()
    {
        // カート情報
        $ec_cart_details = EcCartDetail::query()
            ->with('ec_products')
            ->where('ec_cart_details.cart_id', '=', session()->get('cart-id'))
            ->where('ec_cart_details.product_id', '=', 'ec_products.id')
            ->orderBy('ec_cart_details.id')
            ->paginate(6);
        //
        return view('ec_site.cart', ['ec_cart_details' => $ec_cart_details]);
    }
}
