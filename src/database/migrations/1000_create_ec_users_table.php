<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ec_users', function (Blueprint $table) {
            $table->id()->primary()->comment('ID');
            $table->string('user_id', 255)->unique()->comment('ユーザーID');
            $table->string('user_name', 255)->comment('ユーザー氏名（漢字）');
            $table->string('user_kana', 255)->comment('ユーザー氏名（かな）');
            $table->string('email', 255)->unique()->comment('メールアドレス');
            $table->string('password', 255)->comment('パスワード');
            $table->unsignedBigInteger('cart_id')->nullable()->comment('カートID');
            $table->boolean('admin_flg')->comment('管理フラグ');
            $table->boolean('enable_flg')->comment('有効フラグ');
            $table->dateTime('last_login_at')->nullable()->comment('最終ログイン日時');
            $table->dateTime('email_verified_at')->nullable()->comment('メールアドレス確認日時');
            $table->rememberToken()->comment('Remenber Token');
            $table->string('api_token', 60)->unique()->nullable()->comment('API Token');
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
        Schema::dropIfExists('ec_users', function (Blueprint $table) {
            // インデックス削除
            $table->dropIndex('ec_users_user_id_unique');
            $table->dropIndex('ec_users_email_unique');
            // 外部キー制約の削除
            $table->dropForeign('ec_users_created_by_foreign');
            $table->dropForeign('ec_users_updated_by_foreign');
        });
    }
};
