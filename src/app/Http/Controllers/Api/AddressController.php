<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EcAddress;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function address($id)
    {
        // 配送先情報を取得
        $address = EcAddress::query()
            ->with('ec_prefs')
            ->where('id', '=', $id)
            ->first();
        // 検索結果を返す
        if (empty($address)) {
            return response()->json(
                ['message' => 'Not Found'],
                404,
                [],
                JSON_UNESCAPED_UNICODE
            );
        } else {
            return response()->json(
                $address,
                200,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }
    }
}
