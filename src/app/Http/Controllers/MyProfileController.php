<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EcUser;
use Illuminate\Support\Facades\Auth;

class MyProfileController extends Controller
{
    public function index()
    {
        //
        $ec_user = EcUser::query()->find(Auth::id());
        //
        return view('ec_site.profile', ['ec_user' => $ec_user]);
    }
}
