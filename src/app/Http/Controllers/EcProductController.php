<?php

namespace App\Http\Controllers;

use App\Models\EcProduct;
use App\Http\Requests\EcProductCreateRequest;
use App\Http\Requests\EcProductUpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EcProductController extends Controller
{
    protected $fillable = [
        'name',
        'image_data',
        'image_type',
        'qty',
        'price',
        'public_flg',
    ];

    // 一覧表示
    public function index()
    {
        //
        $ec_products = EcProduct::orderBy('id', 'asc')->paginate(6);
        //
        return view('ec_site.products', ['ec_products' => $ec_products]);
    }

    // 商品登録
    public function store(EcProductCreateRequest $request)
    {
        // 検証済みデータ
        $valid_data = $request->safe();
        // 商品登録処理
        try {
            // 商品レコード生成
            $ec_product = new EcProduct();
            // 商品設定
            $ec_product->name = $valid_data->name;
            $ec_product->qty = $valid_data->qty;
            $ec_product->price = $valid_data->price;
            $ec_product->public_flg = $request->public_flg == 'on' ? true : false;
            // 画像設定
            $ec_product->image_data = base64_encode(file_get_contents($request->image->getRealPath()));
            $ec_product->image_type = mime_content_type($request->image->getRealPath());
            // 登録
            $ec_product->save();
        } catch (\Exception $e) {
            // ログ出力
            Log::error('商品情報の登録に失敗しました。');
            Log::error($e);
            //
            return redirect()
                ->route('users.index')
                ->with('message', '商品情報の登録に失敗しました。');
        }
        //
        return redirect()
            ->route('products.index')
            ->with('message', '商品情報を登録しました。');
    }

    // 商品更新
    public function update(EcProductUpdateRequest $request)
    {
        // 検証済みデータ
        $valid_data = $request->safe();

        switch (true) {
            case $request->has('public'):
                // 商品公開フラグ更新
                try {
                    // 商品レコード取得
                    $ec_product = EcProduct::find($request->id);
                    // 公開フラグ更新
                    $ec_product->public_flg = $ec_product->public_flg == 1 ? 0 : 1;
                    // 保存
                    $ec_product->save();
                } catch (\Exception $e) {
                    // ログ出力
                    Log::error('商品の' . ($ec_product->public_flg == 1 ? '非公開' : '公開') . '設定に失敗しました。');
                    Log::error('商品ID： ' . $ec_product->id);
                    Log::error($e);
                    //
                    return redirect()
                        ->route('users.index')
                        ->with('message', '商品の' . ($ec_product->public_flg == 1 ? '非公開' : '公開') . '設定に失敗しました。商品名： ' . $ec_product->name);
                }
                // メッセージ設定
                session()->flush('message', '商品を' . ($ec_product->public_flg == 1 ? '非公開' : '公開') . '設定にしました。商品名： ' . $ec_product->name);
                break;
            case $request->has('update'):
                // 商品情報更新
                try {
                    // 商品レコード取得
                    $ec_product = EcProduct::find($request->id);
                    // 商品設定
                    $ec_product->name = $valid_data->name;
                    $ec_product->qty = $valid_data->qty;
                    $ec_product->price = $valid_data->price;
                    // 画像設定
                    if (!empty($request->image)) {
                        $ec_product->image_data = base64_encode(file_get_contents($request->image->getRealPath()));
                        $ec_product->image_type = mime_content_type($request->image->getRealPath());
                    }
                    // 保存
                    $ec_product->save();
                } catch (\Exception $e) {
                    // ログ出力
                    Log::error('商品情報の更新に失敗しました。');
                    Log::error('商品ID： ' . $ec_product->id . ' ／ 商品名： ' . $ec_product->name);
                    Log::error($e);
                    //
                    return redirect()
                        ->route('users.index')
                        ->with('message', '商品情報の更新に失敗しました。商品ID： ' . $ec_product->id . ' ／ 商品名： ' . $ec_product->name);
                }
                // メッセージ設定
                session()->flush('message', '商品情報を更新しました。商品ID： ' . $ec_product->id . ' ／ 商品名： ' . $ec_product->name);
                break;
        }
        //
        return redirect()
            ->route('products.index');
    }
}
