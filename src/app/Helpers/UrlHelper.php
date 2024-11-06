<?php

namespace App\Helpers;

class UrlHelper
{
    public static function generateUrl($path)
    {
        $baseUrl = rtrim(config('app.url'), '/');
        $urlPath = parse_url($path, PHP_URL_PATH);
        $urlQuery = parse_url($path, PHP_URL_QUERY);

        // フルURLが含まれているかチェック
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            // サブディレクトリが含まれていない場合のみ追加
            if (strpos($path, $baseUrl) === false) {
                return $baseUrl . '/' . ltrim($urlPath, '/') . '?' . ltrim($urlQuery, '?');
            }
            return $path;
        }
        return $baseUrl . '/' . ltrim($urlPath, '/') . '?' . ltrim($urlQuery, '?');
    }
}
