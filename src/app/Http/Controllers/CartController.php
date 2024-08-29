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
            ->find(session()->get('cart-id'))
            ->with(['ec_products:id,name,image_data,image_type,qty,price'])
            ->orderBy('id', 'asc')
            ->paginate(6);
        //
        return view('ec_site.cart', ['ec_cart_details' => $ec_cart_details]);
    }
}
