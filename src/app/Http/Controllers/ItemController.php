<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\EcUser;
use App\Models\EcProduct;
use App\Models\EcCart;
use App\Models\EcCartDetail;
use App\Http\Requests\ItemStoreRequest;

use function PHPUnit\Framework\isNull;

class ItemController extends Controller
{
    public function index()
    {
        // 商品情報（公開されているもの）
        $ecProducts = EcProduct::query()
            ->where('public_flg', '=', 1)
            ->orderBy('id', 'asc')
            ->paginate(12);
        //
        return view('ec_site.items', ['ecProducts' => $ecProducts]);
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
                    $ecCart = new EcCart();
                    $ecCart->user_id = Auth::id();
                    $ecCart->checkout_flg = 0;
                    $ecCart->checkout_qty = 0;
                    $ecCart->checkout_total = 0;
                    $ecCart->save();
                    // カートIDをEcUserモデルに保存
                    $ecUser = EcUser::find(Auth::id());
                    $ecUser->cart_id = $ecCart->id;
                    $ecUser->save();
                    // カートID
                    Auth::user()->refresh();
                    $ecCartId = $ecCart->id;
                } else {
                    // カートレコード取得
                    $ecCart = EcCart::query()
                        ->where('id', '=', Auth::user()->cart_id)
                        ->get();
                    // カートID
                    $ecCartId = Auth::user()->cart_id;
                }
                // カート明細
                $ecCartDetail = EcCartDetail::createOrFirst(
                    [
                        'price' => $request->order_price,
                        'qty' => $order->order_qty
                    ],
                    [
                        'cart_id' => $ecCartId,
                        'product_id' => $request->id,
                    ]
                );
                $ecCartDetail->save();
            });
        } catch (\Exception $e) {
            // ロールバック
            DB::rollBack();
            // ログ出力
            Log::error("商品のカートへの登録に失敗しました。");
            Log::error($e);
            //
            return redirect(url(null, null, app()->isProduction())->previous())
                ->with('message', '商品のカートへの登録に失敗しました。');
        }
        // リダイレクト
        return redirect(url(null, null, app()->isProduction())->previous())
            ->with('message', '商品をカートに登録しました。 商品名： ' . $request->name . '　数量： ' . $order->order_qty . '点');
    }
}
