<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EcAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function address($id)
    {
        // 配送先情報を取得
        $ecAddress = EcAddress::query()
            ->with('ec_prefs')
            ->where('id', '=', $id)
            ->first();

        // 認可処理
        $this->authorize('view', [Auth::user(), $ecAddress]);

        //  結果を返す
        return response()->json(
            $ecAddress,
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }
}
