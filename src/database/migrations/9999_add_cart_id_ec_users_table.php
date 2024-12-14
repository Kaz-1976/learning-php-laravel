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
        // ユーザーテーブルのカートIDに外部キー（カートテーブルのID）を追加
        Schema::table('ec_users', function (Blueprint $table) {
            $table->foreign('cart_id')->references('id')->on('ec_carts');
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
