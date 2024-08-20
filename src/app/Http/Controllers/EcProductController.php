<?php

namespace App\Http\Controllers;

use App\Models\EcProduct;
use App\Http\Requests\EcProductCreateRequest;
use App\Http\Requests\EcProductUpdateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EcProductController extends Controller
{
    protected $fillable = [
        'product_name',
        'product_image_data',
        'product_image_type',
        'qty',
        'price',
        'public_flg',
    ];

    // ログインしてなければログインページへ
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 一覧表示
    public function index()
    {
        //
        $ec_products = EcProduct::paginate(5);
        //
        return view('ec_site.products', ['ec_products' => $ec_products]);
    }

    // 商品登録
    public function store(EcProductCreateRequest $request)
    {
        // 検証済みデータ
        $valid_data = $request->safe();

        // 商品レコード生成
        $ec_product = new EcProduct();

        // 商品設定
        $ec_product->product_name = $valid_data->product_name;
        $ec_product->qty = $valid_data->qty;
        $ec_product->price = $valid_data->price;
        $ec_product->public_flg = $request->public_flg == 'on' ? true : false;

        // 画像設定
        $ec_product->product_image_data = base64_encode(file_get_contents($request->image->getRealPath()));
        $ec_product->product_image_type = mime_content_type($request->image->getRealPath());

        // 登録
        $ec_product->save();

        //
        return redirect(route('products.index'));
    }

    // ユーザー更新
    public function update(EcProductUpdateRequest $request)
    {
        // 検証済みデータ
        $valid_data = $request->safe();

        // 商品レコード取得
        $ec_product = EcProduct::find($request->id);

        switch (true) {
            case $request->has('public_flg'):
                // 有効フラグ更新
                $ec_product->public_flg = $ec_product->public_flg == 1 ? 0 : 1;
                // 保存
                $ec_product->update();
                break;
            case $request->has('update'):
                // 商品設定
                $ec_product->product_name = $valid_data->product_name;
                $ec_product->qty = $valid_data->qty;
                $ec_product->price = $valid_data->price;
                // 画像設定
                if (!empty($request->image)) {
                    $ec_product->product_image_data = base64_encode(file_get_contents($request->image->getRealPath()));
                    $ec_product->product_image_type = mime_content_type($request->image->getRealPath());
                }
                // 保存
                $ec_product->save();
                break;
        }

        //
        return redirect(route('products.index'));
    }
}
