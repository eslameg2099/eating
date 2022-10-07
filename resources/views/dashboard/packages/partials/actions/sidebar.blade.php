@component('dashboard::components.sidebarItem')
    @slot('can', ['ability' => 'viewAny', 'model' => \App\Models\Package::class])
    @slot('url', route('dashboard.packages.index'))
    @slot('name', trans('packages.plural'))
    @slot('active', request()->routeIs('*packages*'))
    @slot('icon', 'fas fa-th')
    @slot('tree', [
        [
            'name' => trans('packages.actions.list'),
            'url' => route('dashboard.packages.index'),
            'can' => ['ability' => 'viewAny', 'model' => \App\Models\Package::class],
            'active' => request()->routeIs('*packages.index')
            || request()->routeIs('*packages.show'),
        ],
        [
            'name' => trans('packages.actions.create'),
            'url' => route('dashboard.packages.create'),
            'can' => ['ability' => 'create', 'model' => \App\Models\Package::class],
            'active' => request()->routeIs('*packages.create'),
        ],
    ])
@endcomponent
