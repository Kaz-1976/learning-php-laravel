<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EcProduct;

class EcProductController extends Controller
{
    // ログインしてなければログインページへ
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 一覧表示
    public function index()
    {
        //
        $ec_products = EcProduct::all();
        //
        return view('ec_site.products', ['ec_products' => $ec_products]);
    }
}
