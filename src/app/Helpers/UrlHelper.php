<?php

namespace App\Helpers;

class UrlHelper
{
    public static function generateUrl($path)
    {
        $baseUrl = rtrim(config('app.url'), '/');

        // フルURLが含まれているかチェック
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            // サブディレクトリが含まれていない場合のみ追加
            if (strpos($path, $baseUrl) === false) {
                $url_path = parse_url($path, PHP_URL_PATH);
                return $baseUrl . '/' . ltrim($url_path, '/');
            }
            return $path;
        }

        return $baseUrl . '/' . ltrim($path, '/');
    }
}
