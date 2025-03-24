<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\EcZip;
use Illuminate\Support\Facades\Log;

class ZipController extends Controller
{
    public function get($code)
    {
        // 郵便番号から住所を取得
        $ecZip = EcZip::query()
            ->where('code', '=', $code)
            ->first();

        // データが見つからない場合
        if (!$ecZip) {
            return response()->json(
                ['message' => 'Not Found'],
                404,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }

        // 住所情報を返す
        return response()->json(
            $ecZip,
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }
}
