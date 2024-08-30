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
        // ユーザーテーブルにカートIDを追加（外部キー：カートテーブルのID）
        Schema::table('ec_users', function (Blueprint $table) {
            $table->foreignId('cart_id')->nullable()->comment('カートID')->constrained('ec_carts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ec_users', function (Blueprint $table) {
            $table->dropForeign('ec_users_cart_id_foreign');
        });
    }
};
