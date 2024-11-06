<?php

namespace App\Helpers;

class UrlHelper
{
    public static function generateUrl($path)
    {
        $baseUrl = config('app.url'); // APP_URL環境変数を取得

        // フルURLがすでに含まれている場合はそのまま返す
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }
}
