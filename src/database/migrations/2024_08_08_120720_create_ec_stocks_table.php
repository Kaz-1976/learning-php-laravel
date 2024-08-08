<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ec_stocks', function (Blueprint $table) {
            $table->id()->primary()->comment('在庫ID');
            $table->foreignId('product_id')->comment('商品ID')->constrained('ec_products');
            $table->integer('stock_qty')->comment('在庫数');
            $table->foreignId('create_user')->comment('作成ユーザー')->constrained('ec_users');
            $table->timestamp('created_at')->comment('作成日時');
            $table->foreignId('update_user')->comment('最終更新ユーザー')->constrained('ec_users');
            $table->timestamp('updated_at')->comment('最終更新日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ec_stocks', function (Blueprint $table) {
            // 外部キー制約の削除
            $table->dropForeign('ec_stocks_product_id_foreign');
            $table->dropForeign('ec_stocks_create_user_foreign');
            $table->dropForeign('ec_stocks_update_user_foreign');
        });
    }
};
