<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EcMasterTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 外部キー制約無効化
        Schema::disableForeignKeyConstraints();

        // バッチサイズ
        $batchSize = 250;

        // 都道府県コード（配列）
        $arrayPrefCode = [
            ['code' => '01', 'name' => '北海道', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '02', 'name' => '青森県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '03', 'name' => '岩手県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '04', 'name' => '宮城県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '05', 'name' => '秋田県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '06', 'name' => '山形県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '07', 'name' => '福島県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '08', 'name' => '茨城県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '09', 'name' => '栃木県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '10', 'name' => '群馬県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '11', 'name' => '埼玉県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '12', 'name' => '千葉県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '13', 'name' => '東京都', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '14', 'name' => '神奈川県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '15', 'name' => '新潟県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '16', 'name' => '富山県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '17', 'name' => '石川県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '18', 'name' => '福井県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '19', 'name' => '山梨県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '20', 'name' => '長野県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '21', 'name' => '岐阜県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '22', 'name' => '静岡県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '23', 'name' => '愛知県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '24', 'name' => '三重県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '25', 'name' => '滋賀県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '26', 'name' => '京都府', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '27', 'name' => '大阪府', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '28', 'name' => '兵庫県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '29', 'name' => '奈良県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '30', 'name' => '和歌山県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '31', 'name' => '鳥取県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '32', 'name' => '島根県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '33', 'name' => '岡山県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '34', 'name' => '広島県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '35', 'name' => '山口県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '36', 'name' => '徳島県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '37', 'name' => '香川県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '38', 'name' => '愛媛県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '39', 'name' => '高知県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '40', 'name' => '福岡県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '41', 'name' => '佐賀県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '42', 'name' => '長崎県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '43', 'name' => '熊本県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '44', 'name' => '大分県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '45', 'name' => '宮崎県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '46', 'name' => '鹿児島県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
            ['code' => '47', 'name' => '沖縄県', 'created_by' => 1, 'created_at' => now(), 'updated_by' => 1, 'updated_at' => now()],
        ];

        // 都道府県テーブル登録
        DB::table('ec_prefs')->insert($arrayPrefCode);

        // 市区町村コード（CSVファイル）
        $csvCityCode = database_path('seeds/area_code.csv');

        // 市区町村テーブル登録
        try {
            if (($handle = fopen($csvCityCode, 'r')) !== false) {
                // バッチデータ初期化
                $batchData = [];
                // CSV読み取り処理
                while (($row = fgetcsv($handle)) !== false) {
                    // ヘッダー定義
                    $header = [
                        'pref_code',
                        'city_code',
                        'code',
                        'pref_name',
                        'city_name1',
                        'city_name2',
                        'city_name3',
                        'city_kana'
                    ];

                    // ヘッダーと行データを組み合わせる
                    $data = array_combine($header, $row);

                    // 市区町村コードが'000'のデータはスキップ
                    if ($data['city_code'] == '000') {
                        continue;
                    }

                    // バッチデータセット
                    $batchData[] = [
                        'pref_code' => $data['pref_code'],
                        'code' => $data['city_code'],
                        'name' => $data['city_name1'] . $data['city_name3'] . $data['city_name2'],
                        'created_by' => 1,
                        'created_at' => now(),
                        'updated_by' => 1,
                        'updated_at' => now(),
                    ];

                    // バッチサイズに達したら挿入
                    if (count($batchData) >= $batchSize) {
                        DB::transaction(function () use (&$batchData) {
                            // バッチインサート
                            DB::table('ec_cities')->insert($batchData);
                            // バッチデータリセット
                            $batchData = [];
                        });
                    }
                }

                // 残りのデータを挿入
                if (!empty($batchData)) {
                    DB::transaction(function () use (&$batchData) {
                        DB::table('ec_cities')->insert($batchData);
                    });
                }

                // ファイルを閉じる
                fclose($handle);
            }
        } catch (\Exception $e) {
            Log::error("Error occurred while processing CSV: " . $csvCityCode);
            Log::error($e->getMessage());
        }

        // 郵便番号（CSVファイル）
        $csvZipCode = database_path('seeds/zip_code.csv');

        // 郵便番号テーブル登録
        try {
            if (($handle = fopen($csvZipCode, 'r')) !== false) {
                // バッチデータ初期化
                $batchData = [];
                // CSV読み取り処理
                while (($row = fgetcsv($handle)) !== false) {
                    // ヘッダー定義
                    $header = [
                        'city_code',
                        'zip_code_5',
                        'zip_code_7',
                        'pref_kana',
                        'city_kana',
                        'town_kana',
                        'pref_name',
                        'city_name',
                        'town_name',
                        'town_divide_flag',
                        'street_address_flag',
                        'city_block_flag',
                        'town_merge_flag',
                        'update_data_flag',
                        'update_reason_flag',
                    ];

                    // ヘッダーと行データを組み合わせる
                    $data = array_combine($header, $row);

                    // バッチデータ設定
                    $batchData[] = [
                        'code' => $data['zip_code_7'],
                        'pref_code' => substr($data['city_code'], 0, 2),
                        'city_code' => substr($data['city_code'], 2, 3),
                        'area_name' => $data['city_name'] . $data['town_name'],
                        'created_by' => 1,
                        'created_at' => now(),
                        'updated_by' => 1,
                        'updated_at' => now(),
                    ];

                    // バッチサイズに達したら挿入
                    if (count($batchData) >= $batchSize) {
                        DB::transaction(function () use (&$batchData) {
                            // バッチインサート
                            DB::table('ec_zips')->insert($batchData);
                            // バッチデータリセット
                            $batchData = [];
                        });
                    }
                }

                // 残りのデータを挿入
                if (!empty($batchData)) {
                    DB::transaction(function () use (&$batchData) {
                        DB::table('ec_zips')->insert($batchData);
                    });
                }

                // ファイルを閉じる
                fclose($handle);
            }
        } catch (\Exception $e) {
            Log::error("Error occurred while processing CSV: " . $csvZipCode);
            Log::error($e->getMessage());
        }

        // 外部キー制約有効化
        Schema::enableForeignKeyConstraints();
    }
}
