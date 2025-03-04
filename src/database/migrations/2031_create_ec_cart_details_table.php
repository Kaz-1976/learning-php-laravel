<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ec_cart_details', function (Blueprint $table) {
            //
            $table->foreignId('cart_id')->comment('カートID')->constrained('ec_carts');
            $table->id()->primary()->comment('カート明細ID');
            $table->foreignId('product_id')->comment('商品ID')->constrained('ec_products');
            $table->integer('price')->comment('商品価格');
            $table->integer('qty')->comment('商品数');
            $table->foreignId('created_by')->comment('作成ユーザー')->constrained('ec_users');
            $table->dateTime('created_at')->comment('作成日時');
            $table->foreignId('updated_by')->comment('最終更新ユーザー')->constrained('ec_users');
            $table->dateTime('updated_at')->comment('最終更新日時');
            //
            $table->unique(['cart_id', 'product_id'], 'ec_cart_details_cart_id_product_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ec_cart_details', function (Blueprint $table) {
            // ユニークキー削除
            $table->dropUnique('ec_cart_details_cart_id_product_id_unique');
            // 外部キー制約の削除
            $table->dropForeign('ec_cart_detail_cart_id_foreign');
            $table->dropForeign('ec_cart_detail_product_id_foreign');
            $table->dropForeign('ec_cart_detail_created_by_foreign');
            $table->dropForeign('ec_cart_detail_updated_by_foreign');
        });
    }
};
