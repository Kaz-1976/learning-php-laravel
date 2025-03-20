<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\EcProduct;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{

    public function show($id)
    {
        // 画像モデルを取得
        $ecProduct = EcProduct::findOrFail($id);

        // 認可処理
        $this->authorize('view',  $ecProduct);

        // レスポンスとして画像を返す
        return response(
            base64_decode($ecProduct->image_data),
            200,
            [
                'Content-Type' => $ecProduct->image_type,
                'Content-Length' => strlen(base64_decode($ecProduct->image_data)),
            ]
        );
    }
}
