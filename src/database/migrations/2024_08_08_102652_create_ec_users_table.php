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
        Schema::create('ec_users', function (Blueprint $table) {
            $table->id('id')->primary()->comment('ID');
            $table->rememberToken()->comment('Remenber Token');
            $table->string('user_id', 255)->comment('ユーザーID');
            $table->string('user_name', 255)->comment('ユーザー氏名（漢字）');
            $table->string('user_kana', 255)->comment('ユーザー氏名（かな）');
            $table->string('email', 255)->comment('メールアドレス');
            $table->string('password', 255)->comment('パスワード');
            $table->boolean('admin_flg')->comment('管理フラグ');
            $table->boolean('enable_flg')->comment('有効フラグ');
            $table->timestamp('last_login_at')->nullable()->comment('最終ログイン日時');
            $table->timestamp('email_verified_at')->nullable()->comment('メールアドレス確認日時');
            $table->foreignId('created_by')->comment('作成ユーザー')->constrained('ec_users');
            $table->timestamp('created_at')->comment('作成日時');
            $table->foreignId('updated_by')->comment('最終更新ユーザー')->constrained('ec_users');
            $table->timestamp('updated_at')->comment('最終更新日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ec_users', function (Blueprint $table) {
            // 外部キー制約の削除
            $table->dropForeign('ec_users_created_by_foreign');
            $table->dropForeign('ec_users_updated_by_foreign');
        });
    }
};
