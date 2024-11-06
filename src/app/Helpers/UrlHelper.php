<?php

namespace App\Helpers;

class UrlHelper
{
    public static function generateUrl($path)
    {
        $baseUrl = config('app.url'); // APP_URL環境変数を取得
        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }
}
