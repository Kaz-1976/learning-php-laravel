<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EcProduct;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function image($id)
    {
        // 商品情報を取得
        $ecProduct = EcProduct::find($id);
        // 検索結果を返す
        if (empty($ecProduct)) {
            return response(
                '',
                404,
                []
            );
        } else {
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
}
