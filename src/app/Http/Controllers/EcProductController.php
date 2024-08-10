<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EcProductController extends Controller
{
    // ログインしてなければログインページへ
    public function __construct(){
        $this->middleware('auth');
    }

}
