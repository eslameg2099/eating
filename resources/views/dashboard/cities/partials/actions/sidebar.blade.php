@component('dashboard::components.sidebarItem')
    @slot('can', ['ability' => 'viewAny', 'model' => \App\Models\City::class])
    @slot('url', route('dashboard.cities.index'))
    @slot('name', trans('cities.plural'))
    @slot('active', request()->routeIs('*cities*'))
    @slot('icon', 'fas fa-city')
    @slot('tree', [
        [
            'name' => trans('cities.actions.list'),
            'url' => route('dashboard.cities.index'),
            'can' => ['ability' => 'viewAny', 'model' => \App\Models\City::class],
            'active' => request()->routeIs('*cities.index')
            || request()->routeIs('*cities.show'),
        ],
        [
            'name' => trans('cities.actions.create'),
            'url' => route('dashboard.cities.create'),
            'can' => ['ability' => 'create', 'model' => \App\Models\City::class],
            'active' => request()->routeIs('*cities.create'),
        ],
    ])
@endcomponent
