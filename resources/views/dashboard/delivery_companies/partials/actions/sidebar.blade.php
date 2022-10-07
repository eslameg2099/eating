@component('dashboard::components.sidebarItem')
    @slot('can', ['ability' => 'viewAny', 'model' => \App\Models\DeliveryCompany::class])
    @slot('url', route('dashboard.delivery_companies.index'))
    @slot('name', trans('delivery_companies.plural'))
    @slot('active', request()->routeIs('*delivery_companies*'))
    @slot('icon', 'fas fa-th')
    @slot('tree', [
        [
            'name' => trans('delivery_companies.actions.list'),
            'url' => route('dashboard.delivery_companies.index'),
            'can' => ['ability' => 'viewAny', 'model' => \App\Models\DeliveryCompany::class],
            'active' => request()->routeIs('*delivery_companies.index')
            || request()->routeIs('*delivery_companies.show'),
        ],
        [
            'name' => trans('delivery_companies.actions.create'),
            'url' => route('dashboard.delivery_companies.create'),
            'can' => ['ability' => 'create', 'model' => \App\Models\DeliveryCompany::class],
            'active' => request()->routeIs('*delivery_companies.create'),
        ],
    ])
@endcomponent
