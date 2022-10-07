@component('dashboard::components.sidebarItem')
    @slot('can', ['ability' => 'viewAny', 'model' => \App\Models\Coupon::class])
    @slot('url', route('dashboard.coupons.index'))
    @slot('name', trans('coupons.plural'))
    @slot('active', request()->routeIs('*coupons*'))
    @slot('icon', 'fas fa-th')
    @slot('tree', [
        [
            'name' => trans('coupons.actions.list'),
            'url' => route('dashboard.coupons.index'),
            'can' => ['ability' => 'viewAny', 'model' => \App\Models\Coupon::class],
            'active' => request()->routeIs('*coupons.index')
            || request()->routeIs('*coupons.show'),
        ],
        [
            'name' => trans('coupons.actions.create'),
            'url' => route('dashboard.coupons.create'),
            'can' => ['ability' => 'create', 'model' => \App\Models\Coupon::class],
            'active' => request()->routeIs('*coupons.create'),
        ],
    ])
@endcomponent
