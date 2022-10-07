<?php

namespace App\Providers;

use App\Support\Payment\CashierManager;
use App\Support\Payment\Http\Controllers\HyperpayController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CashierServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('cashier', function () {
            return new CashierManager();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Route::get('hyperpay/notify', HyperpayController::class)->name('hyperpay.notify');
    }
}
