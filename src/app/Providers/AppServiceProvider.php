<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use App\Models\EcProduct;
use App\Policies\ProductImagePolicy;
use App\Models\EcReceiptDetail;
use App\Policies\ReceiptImagePolicy;
use App\Models\EcAddress;
use App\Policies\AddressInfoPolicy;

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
        // Policy
        Gate::policy(EcAddress::class, AddressInfoPolicy::class);
        Gate::policy(EcProduct::class, ProductImagePolicy::class);
        Gate::policy(EcReceiptDetail::class, ReceiptImagePolicy::class);
    }
}
