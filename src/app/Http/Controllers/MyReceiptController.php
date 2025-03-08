<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EcReceipt;
use App\Models\EcReceiptDetail;

class MyReceiptController extends Controller
{
    public function index()
    {
        // レシート情報
        $ecReceipts = EcReceipt::query()
            ->where('user_id', '=', Auth::id())
            ->orderBy('id', 'asc')
            ->paginate(6);

        //
        return view('ec_site.receipt', ['ecReceipts' => $ecReceipts]);
    }

    public function show($id)
    {
        // レシート情報
        $ecReceipt = EcReceipt::find($id);
        // レシート詳細情報
        $ecReceiptDetails = EcReceiptDetail::query()
            ->where('receipt_id', '=', $id)
            ->orderBy('id', 'asc')
            ->paginate(6);
        //
        return view('ec_site.receipt-detail', ['ecReceipt' => $ecReceipt, 'ecReceiptDetails' => $ecReceiptDetails]);
    }
}
