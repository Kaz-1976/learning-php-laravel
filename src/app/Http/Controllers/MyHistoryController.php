<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EcReceipt;

class MyHistoryController extends Controller
{
    public function index()
    {
        // カート情報（決済完了しているもの）
        $ecReceipts = EcReceipt::query()
            ->where('user_id', '=', Auth::id())
            ->orderBy('id', 'asc')
            ->paginate(6);

        //
        return view('ec_site.history', ['ecReceipts' => $ecReceipts]);
    }
}
