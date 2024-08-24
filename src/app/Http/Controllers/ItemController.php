<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EcProduct;

class ItemController extends Controller
{
    public function index()
    {
        // 商品情報（公開されているもの）
        $ec_products = EcProduct::where('public_flg', '=', 1)->orderBy('id','asc')->paginate(12);

        //
        return view('ec_site.items', ['ec_products' => $ec_products]);
    }
}
