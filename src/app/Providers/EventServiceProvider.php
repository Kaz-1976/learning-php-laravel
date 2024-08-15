<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Observers\ModelObserver;

// モデル
use App\Models\EcUser;
use App\Models\EcProduct;
use App\Models\EcStock;
use App\Models\EcCart;
use App\Models\EcCartDetail;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LoginListener',
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        EcUser::observe(ModelObserver::class);
        EcProduct::observe(ModelObserver::class);
        EcStock::observe(ModelObserver::class);
        EcCart::observe(ModelObserver::class);
        EcCartDetail::observe(ModelObserver::class);
    }
}
