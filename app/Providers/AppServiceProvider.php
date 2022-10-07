<?php

namespace App\Providers;

use App\Models\Vote;
use App\Models\Order;
use App\Observers\VoteObserver;
use App\Observers\OrderObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Http\Validation_helpers\less_than;
use App\View\Forms\Components\ColorComponent;
use App\View\Forms\Components\PriceComponent;
use Laraeast\LaravelBootstrapForms\Facades\BsForm;

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
        Vote::observe(VoteObserver::class);
        Order::observe(OrderObserver::class);
        BsForm::registerComponent('price', PriceComponent::class);
        BsForm::registerComponent('color', ColorComponent::class);
        Paginator::useBootstrap();
        less_than::lessThan();
    }
}
