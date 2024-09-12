<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\EcUser;
use App\Models\EcProduct;
use App\Models\EcCart;
use App\Models\EcCartDetail;
use App\Http\Requests\ItemStoreRequest;

class ItemController extends Controller
{
    public function index()
    {
        // 商品情報（公開されているもの）
        $ec_products = EcProduct::query()
            ->where('public_flg', '=', 1)
            ->orderBy('id', 'asc')
            ->paginate(12);

        //
        return view('ec_site.items', ['ec_products' => $ec_products]);
    }

    public function store(ItemStoreRequest $request)
    {
        // ポストデータ取得
        $order = $request->safe();
        // トランザクション
        try {
            DB::transaction(function () use ($order, $request) {
                // カートID取得
                if (empty(Auth::user()->cart_id)) {
                    // カートを生成する
                    $cart = new EcCart();
                    $cart->user_id = Auth::id();
                    $cart->checkout_flg = 0;
                    $cart->save();
                    // カートIDをEcUserモデルに保存
                    $ec_user = EcUser::find(Auth::id());
                    $ec_user->cart_id = $cart->id;
                    $ec_user->save();
                    // カートID
                    Auth::user()->refresh();
                    $cart_id = $cart->id;
                } else {
                    // カートレコード取得
                    $cart = EcCart::query()
                        ->where('id', '=', Auth::user()->cart_id)
                        ->get();
                    // カートID
                    $cart_id = Auth::user()->cart_id;
                }
                // カート明細存在チェック
                $ecCartDetail = EcCartDetail::query()
                    ->where('cart_id', '=', $cart_id)
                    ->where('product_id', '=', $request->id)
                    ->get();
                // カート明細の登録・更新
                if (count($ecCartDetail) == 0) {
                    // カート明細登録
                    $ecCartDetail = new EcCartDetail();
                    $ecCartDetail->cart_id = $cart_id;
                    $ecCartDetail->product_id = $request->id;
                    $ecCartDetail->price = $request->price;
                    $ecCartDetail->qty = $order->order;
                    $ecCartDetail->save();
                } else {
                    // 数量を更新
                    EcCartDetail::query()
                        ->where('cart_id', '=', $cart_id)
                        ->where('product_id', '=', $request->id)
                        ->increment('qty', $order->order);
                }
            });
        } catch (\Exception $e) {
            // ロールバック
            DB::rollBack();
            // ログ出力
            Log::error("商品のカートへの登録に失敗しました。");
            Log::error($e);
            //
            return redirect()
                ->route('users.index')
                ->with('message', '商品のカートへの登録に失敗しました。');
        }
        // リダイレクト
        return redirect()
            ->route('items.index')
            ->with('message', '商品をカートに登録しました。 商品名： ' . $request->name . ' ／ 数量' . $order->order . '点');
    }
}
