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
                return $baseUrl . '/' . ltrim($path, '/');
            }
            return $path;
        }

        return $baseUrl . '/' . ltrim($path, '/');
    }
}
