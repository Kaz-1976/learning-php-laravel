<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EcReceipt;
use App\Models\EcReceiptDetail;
use Illuminate\Support\Facades\Log;

class CompleteController extends Controller
{
    public function index()
    {
        // レシートID取得
        $receipt_id = session()->get('receipt_id');
        Log::info("レシートID：" . $receipt_id);
        // レシート情報取得
        $ecReceipt = EcReceipt::find($receipt_id);
        if (empty($ecReceipt)) {
            $ecReceiptDetails = null;
        } else {
            // カート明細レコード取得
            $ecReceiptDetails = EcReceiptDetail::query()
                ->where('receipt_id', '=', $receipt_id)
                ->paginate(6);
        }
        // リターン
        return view('ec_site.complete')
            ->with([
                'ecReceipt' => $ecReceipt,
                'ecReceiptDetails' => $ecReceiptDetails
            ]);
    }
}
