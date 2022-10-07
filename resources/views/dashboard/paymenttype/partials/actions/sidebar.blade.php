@component('dashboard::components.sidebarItem')
   
    @slot('url', route('dashboard.types.index'))
    @slot('name', trans('types.plural'))
    @slot('active', request()->routeIs('*types*'))
    @slot('icon', 'fas fa-city')
    @slot('tree', [
        [
            'name' => trans('cities.actions.list'),
            'url' => route('dashboard.types.index'),
            'active' => request()->routeIs('*types.index')
            || request()->routeIs('*types.show'),
        ],
     
    ])
@endcomponent
