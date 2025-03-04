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
        Schema::create('ec_zips', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('code')->index()->comment('郵便番号');
            $table->string('pref_code')->foreign('pref_code')->references('code')->on('ec_prefs')->comment('都道府県コード');
            $table->string('city_code')->foreign('city_code')->references('code')->on('ec_cities')->comment('市区町村コード');
            $table->string('area_name',1024)->comment('地域名');
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
        Schema::dropIfExists('ec_zips', function (Blueprint $table) {
            // 外部キー制約の削除
            $table->dropForeign('ec_zips_pref_code_foreign');
            $table->dropForeign('ec_zips_city_code_foreign');
            $table->dropForeign('ec_zips_created_by_foreign');
            $table->dropForeign('ec_zips_updated_by_foreign');
        });
    }
};
