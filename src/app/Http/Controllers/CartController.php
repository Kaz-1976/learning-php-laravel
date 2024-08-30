<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EcCartDetail;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // カート情報
        if (empty(Auth::user()->cart_id)) {
            $ec_cart_details = null;
        } else {
            $ec_cart_details = EcCartDetail::query()
                ->with(['ec_products:id,name,image_data,image_type,qty,price'])
                ->find(Auth::user()->cart_id)
                ->orderBy('id', 'asc')
                ->paginate(6);
        }
        //
        return view('ec_site.cart', ['ec_cart_details' => $ec_cart_details]);
    }
}
