<?php

namespace App\Http\Controllers;

use App\Models\EcProduct;
use App\Http\Requests\EcProductCreateRequest;
use App\Http\Requests\EcProductUpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
        $ecProducts = EcProduct::orderBy('id', 'asc')->paginate(6);
        //
        return view('ec_site.products', ['ecProducts' => $ecProducts]);
    }

    // 商品登録
    public function store(EcProductCreateRequest $request)
    {
        // 検証済みデータ
        $valid_data = $request->safe();
        // 商品登録処理
        try {
            // 商品レコード生成
            $ecProduct = new EcProduct();
            // 商品設定
            $ecProduct->name = $valid_data->name;
            $ecProduct->qty = $valid_data->qty;
            $ecProduct->price = $valid_data->price;
            $ecProduct->public_flg = $request->public_flg == 'on' ? true : false;
            // 画像設定
            $ecProduct->image_data = base64_encode(file_get_contents($request->image->getRealPath()));
            $ecProduct->image_type = mime_content_type($request->image->getRealPath());
            // 登録
            $ecProduct->save();
            // メッセージ設定
            $message = '商品情報を登録しました。';
        } catch (\Exception $e) {
            // ログ出力
            Log::error('商品情報の登録に失敗しました。');
            Log::error($e);
            // メッセージ設定
            $message = '商品情報の登録に失敗しました。';
        }
        // リターン
        return redirect(url(null, null, app()->isProduction())->previous())
            ->with('message', $message);
    }

    // 商品更新
    public function update(EcProductUpdateRequest $request)
    {
        // 検証済みデータ
        $valid_data = $request->safe();

        switch (true) {
            case $request->has('public'):
                // 商品公開フラグ更新
                $message = DB::transaction(function () use ($request, $valid_data) {
                    try {
                        // 商品レコード取得
                        $ecProduct = EcProduct::find($request->id);
                        // 公開フラグ更新
                        $ecProduct->public_flg = $ecProduct->public_flg == 1 ? 0 : 1;
                        // 保存
                        $ecProduct->save();
                    } catch (\Exception $e) {
                        // ログ出力
                        Log::error('商品の' . ($request->public_flg == 1 ? '非公開' : '公開') . '設定に失敗しました。');
                        Log::error('商品ID： ' . $request->id . ' 商品名： ' . $valid_data->name);
                        Log::error($e);
                        // メッセージ設定
                        $message = '商品の' . ($request->public_flg == 1 ? '非公開' : '公開') . '設定に失敗しました。商品名： ' . $valid_data->name;
                        // リターン
                        return $message;
                    }
                    // メッセージ設定
                    $message = '商品を' . ($request->public_flg == 1 ? '非公開' : '公開') . '設定にしました。商品名： ' . $valid_data->name;
                    // リターン
                    return $message;
                });
                break;
            case $request->has('update'):
                // 商品情報更新
                $message = DB::transaction(function () use ($request, $valid_data) {
                    try {
                        // 商品レコード取得
                        $ecProduct = EcProduct::find($request->id);
                        // 商品設定
                        $ecProduct->name = $valid_data->name;
                        $ecProduct->qty = $valid_data->qty;
                        $ecProduct->price = $valid_data->price;
                        // 画像設定
                        if (!empty($request->image)) {
                            $ecProduct->image_data = base64_encode(file_get_contents($request->image->getRealPath()));
                            $ecProduct->image_type = mime_content_type($request->image->getRealPath());
                        }
                        // 保存
                        $ecProduct->save();
                    } catch (\Exception $e) {
                        // ログ出力
                        Log::error('商品情報の更新に失敗しました。');
                        Log::error('商品ID： ' . $request->id . ' ／ 商品名： ' . $valid_data->name);
                        Log::error($e);
                        // メッセージ設定
                        $message = '商品情報の更新に失敗しました。商品ID： ' . $request->id . ' ／ 商品名： ' . $valid_data->name;
                        // リターン
                        return $message;
                    }
                    // メッセージ設定
                    $message = '商品情報を更新しました。商品ID： ' . $request->id . ' ／ 商品名： ' . $valid_data->name;
                    // リターン
                    return $message;
                });
                break;
        }
        //
        return redirect(url(null, null, app()->isProduction())->previous())
            ->with('message', $message);
    }
}
