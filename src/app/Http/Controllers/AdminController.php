<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function index()
    {
        // 管理メニュー
        return view('ec_site.admin');
    }
}
