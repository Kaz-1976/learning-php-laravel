<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EcCart;
use App\Models\EcCartDetail;

class MyHistoryController extends Controller
{
    public function index()
    {
        // カート情報（決済完了しているもの）
        $ecCarts = EcCart::query()
            ->where('user_id', '=', Auth::id())
            ->where('checkout_flg', '=', 1)
            ->orderBy('id', 'asc')
            ->paginate(6);

        //
        return view('ec_site.history', ['ecCarts' => $ecCarts]);
    }
}
