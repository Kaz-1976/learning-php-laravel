<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\EcZip;

class ZipController extends Controller
{
    public function zip($code)
    {
        // 郵便番号から住所を取得
        $ecZip = EcZip::query()
            ->where('code', '=', $code)
            ->first();

        // 認可処理
        $this->authorize('view');

        // 住所情報を返す
        return response()->json(
            $ecZip,
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }
}
