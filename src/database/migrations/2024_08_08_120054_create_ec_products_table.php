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
        Schema::create('ec_products', function (Blueprint $table) {
            $table->id()->primary()->comment('商品ID');
            $table->string('name', 255)->comment('商品名');
            $table->longText('image_data')->comment('商品画像データ');
            $table->string('image_type', 64)->comment('商品画像タイプ');
            $table->integer('qty')->comment('在庫');
            $table->integer('price')->comment('価格');
            $table->boolean('public_flg')->comment('公開フラグ');
            $table->foreignId('created_by')->comment('作成ユーザー')->constrained('ec_users');
            $table->dateTime('created_at')->comment('作成日時');
            $table->foreignId('updated_by')->comment('最終更新ユーザー')->constrained('ec_users');
            $table->dateTime('updated_at')->comment('最終更新日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ec_products', function (Blueprint $table) {
            // 外部キー制約の削除
            $table->dropForeign('ec_products_created_by_foreign');
            $table->dropForeign('ec_products_updated_by_foreign');
        });
    }
};
