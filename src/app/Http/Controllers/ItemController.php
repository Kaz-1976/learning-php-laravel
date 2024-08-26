<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EcProduct;
use App\Models\EcCart;
use App\Models\EcCartDetail;

use App\Http\Requests\ItemStoreRequest;

class ItemController extends Controller
{
    public function index()
    {
        // 商品情報（公開されているもの）
        $ec_products = EcProduct::where('public_flg', '=', 1)->orderBy('id', 'asc')->paginate(12);

        //
        return view('ec_site.items', ['ec_products' => $ec_products]);
    }

    public function store(ItemStoreRequest $request)
    {
        // ポストデータ取得
        $order = $request->safe();
        // トランザクション
        DB::transaction(function () use ($order, $request) {
            // カートID取得
            if (session()->has('cart-id')) {
                // セッションに保存されたカートID
                $cart_id = session()->get('cart-id');
                // カートレコード取得
                $cart = EcCart::where('id', '=', $cart_id);
            } else {
                // カートを生成する
                $cart = new EcCart();
                $cart->user_id = Auth::id();
                $cart->checkout_flg = false;
                $cart->save();
                // カートIDを保存
                $cart_id = $cart->id;
            }
            // カート明細存在チェック
            $ecCartDetail = EcCartDetail::where('cart_id', '=', $cart_id)->where('product_id', '=', $request->id)->get();
            // カート明細の登録・更新
            if (empty($ecCartDetail)) {
                // カート明細登録
                $ecCartDetail = new EcCartDetail();
                $ecCartDetail->cart_id = $cart_id;
                $ecCartDetail->product_id = $request->id;
                $ecCartDetail->price = $request->price;
                $ecCartDetail->qty = $order->order;
                $ecCartDetail->save();
            } else {
                // 数量を更新
                EcCartDetail::where('cart_id', '=', $cart_id)->where('product_id', '=', $request->id)->increment('qty', $order->order);
            }
            // カートID保存
            session()->put('cart-id', $cart_id);
        });
        // リダイレクト
        return redirect(route('items.index'));
    }
}
