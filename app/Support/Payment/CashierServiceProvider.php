<?php

namespace App\Support\Payment;

use App\Support\Payment\Http\Controllers\HyperpayController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CashierServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::get('hyperpay/notify', HyperpayController::class)->name('hyperpay.notify');
    }
}
