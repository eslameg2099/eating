@if(Gate::allows('viewAny', \App\Models\SpecialOrder::class))
    @component('dashboard::components.sidebarItem')
        @slot('url', '#')
        @slot('name', trans('orders.plural'))
        @slot('active', request()->routeIs('*orders*') || request()->routeIs('*speacialOrders*'))
        @slot('icon', 'fas fa-truck')
        @slot('tree', [
            [
                'name' => trans('orders.plural'),
                'url' => route('dashboard.orders.index'),
                'can' => ['ability' => 'viewAny', 'model' => \App\Models\Order::class],
                'active' => request()->routeIs('*orders*'),
            ],
            [
                'name' => trans('orders.plural_delivery'),
                'url' => route('dashboard.deliveries.delivery'),
                'can' => ['ability' => 'viewAny', 'model' => \App\Models\Order::class],
                'active' => request()->routeIs('*deliveries*'),
            ],
            [
                'name' => trans('specialOrders.plural'),
                'url' => route('dashboard.specialOrders.index'),
                'can' => ['ability' => 'viewAny', 'model' => \App\Models\SpecialOrder::class],
                'active' => request()->routeIs('*specialOrders*'),
            ],

        ])
    @endcomponent
@endif
