<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\EcUser;
use App\Models\EcProduct;
use App\Models\EcAddress;
use App\Models\EcCart;
use App\Models\EcCartDetail;
use App\Models\EcReceipt;
use App\Models\EcReceiptDetail;

class CompleteController extends Controller
{
    public function index()
    {
        // レシートID取得
        $receipt_id = session('receipt_id');
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
        //
        return view('ec_site.complete', ['ecReceipt' => $ecReceipt, 'ecReceiptDetails' => $ecReceiptDetails]);
    }
}
