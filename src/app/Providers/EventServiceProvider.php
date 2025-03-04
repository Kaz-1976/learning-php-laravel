<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Observers\ModelObserver;

// モデル
use App\Models\EcUser;
use App\Models\EcAddress;
use App\Models\EcProduct;
use App\Models\EcCart;
use App\Models\EcCartDetail;
use App\Models\EcReceipt;
use App\Models\EcReceiptDetail;
use App\Models\EcPref;
use App\Models\EcCity;
use App\Models\EcZip;

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
        // データテーブル
        EcUser::observe(ModelObserver::class);
        EcAddress::observe(ModelObserver::class);
        EcProduct::observe(ModelObserver::class);
        EcCart::observe(ModelObserver::class);
        EcCartDetail::observe(ModelObserver::class);
        EcReceipt::observe(ModelObserver::class);
        EcReceiptDetail::observe(ModelObserver::class);
        // マスタテーブル
        EcPref::observe(ModelObserver::class);
        EcCity::observe(ModelObserver::class);
        EcZip::observe(ModelObserver::class);
    }
}
