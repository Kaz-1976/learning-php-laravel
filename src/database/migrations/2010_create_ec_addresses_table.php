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
        Schema::create('ec_addresses', function (Blueprint $table) {
            $table->id()->primary()->comment('ID');
            $table->foreignId('user_id')->comment('ユーザーID')->constrained('ec_users');
            $table->string('name')->comment('宛先名');
            $table->string('zip')->comment('郵便番号');
            $table->string('pref')->comment('都道府県');
            $table->string('address1', 1024)->comment('住所１');
            $table->string('address2', 1024)->nullable()->comment('住所２');
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
        Schema::dropIfExists('ec_addresses', function (Blueprint $table) {
            // 外部キー制約の削除
            $table->dropForeign('ec_addresses_user_id_foreign');
            $table->dropForeign('ec_addresses_created_by_foreign');
            $table->dropForeign('ec_addresses_updated_by_foreign');
        });
    }
};
