<x-layout :title="trans('dashboard.home')" :breadcrumbs="['dashboard.home']">
    <div class="row">
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div style="background-color: #AA0116" class="small-box text-white">
                <div class="inner">
                    <div class="row">
                        <div class="col-lg-7 col-6">
                            <h3>{{ \App\Models\Customer::count() }}</h3>
                            <p>{{ trans('home.customers-count') }}</p>
                        </div>
                        <div class="col-lg-4 col-6">
                            <i class="fas fa-7x fa-users text-white-50"></i>
                        </div>

                    </div>
                </div>
                <a href="{{ route('dashboard.customers.index') }}" class="small-box-footer">
                    @lang('عرض المزيد')
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div style="background-color: #AFAFAF" class="small-box ">
                <div class="inner">
                    <div class="row">
                        <div class="col-lg-7 col-6">
                            <h3>{{ \App\Models\Kitchen::where('cookable_type', 'LIKE', "kitchen")->count() }}</h3>
                            <p>{{ trans('home.kitchen-count') }}</p>
                        </div>
                        <div class="col-lg-4 col-6">
                            <i class="fas fa-7x fa-store-alt text-white-50"></i>
                        </div>
                    </div>
                </div>
                <a href="{{ route('dashboard.kitchens.index') }}" class="small-box-footer">
                    @lang('عرض المزيد')
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div style="background-color: #FBB03B" class="small-box bg-warning">
                <div class="inner">
                    <div class="row">
                        <div class="col-lg-7 col-6">
                            <h3>{{ \App\Models\Kitchen::where('cookable_type', 'LIKE', "foodtruck")->count() }}</h3>
                            <p>{{ trans('home.foodtruck-count') }}</p>
                        </div>
                        <div class="col-lg-4 col-6">
                            <i class="fas fa-7x fa-truck text-white-50"></i>
                        </div>
                    </div>
                </div>
                <a href="{{ route('dashboard.kitchens.index') }}" class="small-box-footer">
                    @lang('عرض المزيد')
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <div class="row">
                        <div class="col-lg-7 col-6">
                            <h3>{{ \App\Models\Order::count() }}</h3>
                            <p>{{ trans('home.orders-count') }}</p>
                        </div>
                        <div class="col-lg-4 col-6">
                            <i class="fas fa-7x fa-hamburger text-white-50"></i>
                        </div>
                    </div>
                </div>
                <a href="{{ route('dashboard.orders.index') }}" class="small-box-footer">
                    @lang('عرض المزيد')
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <div class="row">
                        <div class="col-lg-7 col-6">
                            <h3>{{ \App\Models\SpecialOrder::count() }}</h3>
                            <p>{{ trans('home.specialOrders-count') }}</p>
                        </div>
                        <div class="col-lg-4 col-6">
                            <i class="fas fa-7x fa-utensils text-white-50"></i>
                        </div>
                    </div>
                </div>
                <a href="{{ route('dashboard.orders.index') }}" class="small-box-footer">
                    @lang('عرض المزيد')
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <div class="row">
                        <div class="col-lg-7 col-6">
                            <h3>{{ \App\Models\Report::count() }}</h3>
                            <p>{{ trans('home.reports-count') }}</p>
                        </div>
                        <div class="col-lg-4 col-6">
                            <i class="fas fa-7x fa-frown text-white-50"></i>
                        </div>
                    </div>
                </div>
                <a href="{{ route('dashboard.orders.index') }}" class="small-box-footer">
                    @lang('عرض المزيد')
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-gradient-navy">
                <div class="inner">
                    <div class="row">
                        <div class="col-lg-7 col-6">
                            <h3>{{ $chefs_cost }}</h3>
                            <p>{{ trans('home.chefs_money') }}</p>
                        </div>
                        <div class="col-lg-4 col-6">
                            <i class="far fa-7x text-white-50  fa-money-bill-alt"></i>


                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-gradient-navy">
                <div class="inner">
                    <div class="row">
                        <div class="col-lg-7 col-6">
                            <h3>{{ $total_profit }}</h3>
                            <p>{{ trans('home.system_money') }}</p>
                        </div>
                        <div class="col-lg-4 col-6">
                            <i class="fas fa-7x text-white-50 fa-hand-holding-usd"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-gradient-navy">
                <div class="inner">
                    <div class="row">
                        <div class="col-lg-7 col-6">
                            <h3>{{ $wallets }}</h3>
                            <p>{{ trans('home.users_balances') }}</p>
                        </div>
                        <div class="col-lg-4 col-6">
                            <i class="fas fa-7x text-white-50 fa-wallet"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- ./col -->

    </div>

</x-layout>
