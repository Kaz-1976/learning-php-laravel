<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EcReceiptDetail;
use Illuminate\Http\Request;

class ReceiptImageController extends Controller
{
    public function image($id, $no)
    {
        // レシート情報を取得
        $ecReceiptDetail = EcReceiptDetail::query()
            ->where('receipt_id', $id)
            ->where('id', $no)
            ->first();
        // 検索結果を返す
        if (empty($ecReceiptDetail)) {
            return response(
                '',
                404,
                []
            );
        } else {
            return response(
                base64_decode($ecReceiptDetail->image_data),
                200,
                [
                    'Content-Type' => $ecReceiptDetail->image_type,
                    'Content-Length' => strlen(base64_decode($ecReceiptDetail->image_data)),
                ]
            );
        }
    }
}
