<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EcAddress;

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
        //
        return view(
            'ec_site.shipping',
            [
                'ecAddresses' => $ecAddresses
            ]
        );
    }
}
