<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\UrlHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // カスタムBladeディレクティブの定義
        Blade::directive('generateUrl', function ($expression) {
             return "<?php echo UrlHelper::generateUrl($expression); ?>";
        });
    }
}
