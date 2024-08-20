<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EcProduct;

class ItemController extends Controller
{
    public function index()
    {
        // インデックスページ
        if (Auth::check()) {
            // ユーザー情報取得
            $auth = Auth::user();
            // 管理者なら管理メニューへ
            if ($auth->admin_flg) {
                return redirect(route('ec_site.admin', ['auth' => $auth]));
            }
        } else {
            return redirect(route('login'));
        }

        // 商品情報
        $ec_products = EcProduct::where('ec_products.public_flg', '=', 1)->paginate(8);

        //
        return view('ec_site.items', ['ec_products' => $ec_products]);
    }
}
