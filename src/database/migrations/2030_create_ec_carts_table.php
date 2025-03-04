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
        Schema::create('ec_carts', function (Blueprint $table) {
            $table->id()->primary()->comment('カートID');
            $table->foreignId('user_id')->comment('ユーザーID')->constrained('ec_users');
            $table->foreignId('address_id')->comment('配送先ID')->constrained('ec_addresses');
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
        Schema::dropIfExists('ec_carts', function (Blueprint $table) {
            // 外部キー制約の削除
            $table->dropForeign('ec_carts_user_id_foreign');
            $table->dropForeign('ec_carts_address_id_foreign');
            $table->dropForeign('ec_carts_created_by_foreign');
            $table->dropForeign('ec_carts_updated_by_foreign');
        });
    }
};
