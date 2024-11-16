<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyPageController extends Controller
{
    public function index()
    {
        // マイページメニュー
        return view('ec_site.mypage');
    }
}
