<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EcZip;

class ZipController extends Controller
{
    public function zip($code)
    {
        // 郵便番号から住所を取得
        $zip = EcZip::query()
            ->where('code', '=', $code)
            ->first();
        // 検索結果を返す
        if (empty($zip)) {
            return response()->json(
                ['message' => 'Not Found'],
                404,
                [],
                JSON_UNESCAPED_UNICODE
            );
        } else {
            return response()->json(
                $zip,
                200,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }
    }
}
