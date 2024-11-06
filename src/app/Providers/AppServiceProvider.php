<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\UrlHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // カスタムBladeディレクティブの定義
        Blade::directive('generateUrl', function ($expression) {
            return "<?php echo \App\Helpers\UrlHelper::generateUrl($expression); ?>";
        });
    }
}
