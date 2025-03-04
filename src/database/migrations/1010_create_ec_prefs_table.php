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
        Schema::create('ec_prefs', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('code')->unique()->comment('都道府県コード');
            $table->string('name')->comment('都道府県名');
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
        Schema::dropIfExists('ec_prefs', function (Blueprint $table) {
            // インデックス削除
            $table->dropUnique('ec_prefs_code_unique');
            // 外部キー制約の削除
            $table->dropForeign('ec_prefs_created_by_foreign');
            $table->dropForeign('ec_prefs_updated_by_foreign');
        });
    }
};
