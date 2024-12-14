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
            $table->boolean('checkout_flg')->default(false)->comment('決済フラグ');
            $table->dateTime('checkout_date')->nullable()->comment('決済日時');
            $table->integer('checkout_qty')->nullable()->comment('決済数量');
            $table->integer('checkout_total')->nullable()->comment('決済金額');
            $table->foreignId('address_id')->nullable()->comment('配送先ID')->constrained('ec_address');
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
            $table->dropForeign('ec_cart_user_id_foreign');
            $table->dropForeign('ec_cart_created_by_foreign');
            $table->dropForeign('ec_cart_updated_by_foreign');
        });
    }
};
