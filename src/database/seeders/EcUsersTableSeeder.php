<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\EcUser;

class EcUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 外部キー制約無効化
        Schema::disableForeignKeyConstraints();
        // ユーザー登録：データー設定
        $ec_users = [
            // スーパーユーザー
            [
                'remember_token' => null,
                'user_id' => env('DEFAULT_ADMIN_ID', 'ec_admin'),
                'user_name' => env('DEFAULT_ADMIN_NAME', 'スーパーユーザー'),
                'user_kana' => env('DEFAULT_ADMIN_KANA', 'すーぱーゆーざー'),
                'email' => env('DEFAULT_ADMIN_EMAIL', 'ec_admin@example.local'),
                'password' => Hash::make(env('DEFAULT_ADMIN_PASSWORD', 'ec_admin')),
                'cart_id' => null,
                'admin_flg' => true,
                'enable_flg' => true,
                'last_login_at' => null,
                'email_verified_at' => null,
            ],
            // テスト管理者ユーザー
            [
                'remember_token' => null,
                'user_id' => 'TestAdmin01',
                'user_name' => 'テスト管理者０１',
                'user_kana' => 'てすとかんりしゃ０１',
                'email' => 'test-admin+01@inaho.space',
                'password' => Hash::make('TestAdmin01'),
                'cart_id' => null,
                'admin_flg' => true,
                'enable_flg' => true,
                'last_login_at' => null,
                'email_verified_at' => null,
            ],
            // テスト利用者ユーザー
            [
                'remember_token' => null,
                'user_id' => 'TestUser01',
                'user_name' => 'テスト利用者０１',
                'user_kana' => 'てすとりようしゃ０１',
                'email' => 'test-user+01@inaho.space',
                'password' => Hash::make('TestUser01'),
                'cart_id' => null,
                'admin_flg' => false,
                'enable_flg' => true,
                'last_login_at' => null,
                'email_verified_at' => null,
            ],
        ];
        // ユーザー登録：データー登録
        foreach ($ec_users as $ec_user) {
            EcUser::create($ec_user);
        };
        // 外部キー制約有効化
        Schema::enableForeignKeyConstraints();
    }
}
