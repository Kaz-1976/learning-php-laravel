<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EcProduct;

class ItemController extends Controller
{
    public function index()
    {
        // 商品情報（公開されているもの）
        $ecProducts = EcProduct::query()
            ->where('public_flg', '=', 1)
            ->orderBy('id', 'asc')
            ->paginate(12);
        //
        return view('ec_site.items', ['ecProducts' => $ecProducts]);
    }
}
