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
        Schema::create('ec_receipt_details', function (Blueprint $table) {
            //
            $table->foreignId('receipt_id')->comment('レシートID')->constrained('ec_receipts');
            $table->id()->primary()->comment('レシート明細ID');
            $table->string('name')->comment('商品名');
            $table->string('image_type')->comment('商品画像タイプ');
            $table->longText('image_data')->comment('商品画像データ');
            $table->integer('price')->comment('商品価格');
            $table->integer('qty')->comment('商品数量');
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
        Schema::dropIfExists('ec_receipt_details', function (Blueprint $table) {
            // 外部キー制約の削除
            $table->dropForeign('ec_receipt_details_receipt_id_foreign');
            $table->dropForeign('ec_receipt_details_created_by_foreign');
            $table->dropForeign('ec_receipt_details_updated_by_foreign');
        });
    }
};
