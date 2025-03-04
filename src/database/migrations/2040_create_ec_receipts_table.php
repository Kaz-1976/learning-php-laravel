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
        Schema::create('ec_receipts', function (Blueprint $table) {
            $table->id()->primary()->comment('レシートID');
            $table->foreignId('user_id')->comment('ユーザーID')->constrained('ec_users');
            $table->string('no')->comment('注文番号');
            $table->dateTime('date')->comment('注文日時');
            $table->integer('qty')->comment('合計数量');
            $table->integer('amount')->comment('合計金額');
            $table->string('zip')->comment('配送先郵便番号');
            $table->string('address1')->comment('配送先住所１');
            $table->string('address2')->comment('配送先住所２');
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
        Schema::dropIfExists('ec_receipts', function (Blueprint $table) {
            // 外部キー制約の削除
            $table->dropForeign('ec_receipts_user_id_foreign');
            $table->dropForeign('ec_receipts_created_by_foreign');
            $table->dropForeign('ec_receipts_updated_by_foreign');
        });
    }
};
