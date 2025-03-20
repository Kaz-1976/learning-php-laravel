<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\EcReceiptDetail;
use Illuminate\Http\Request;

class ReceiptImageController extends Controller
{
    public function show($id, $no)
    {
        // レシート情報を取得
        $ecReceiptDetail = EcReceiptDetail::query()
            ->with('ec_receipts')
            ->where('receipt_id', '=', $id)
            ->where('id', '=', $no)
            ->firstOrFail();

        // 認可処理
        $this->authorize('view', $ecReceiptDetail);

        // 画像を返す
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
