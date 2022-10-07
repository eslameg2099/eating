@if(Gate::allows('viewAny', \App\Models\Kitchen::class))
    @component('dashboard::components.sidebarItem')
        @slot('url', '#')
        @slot('name', trans('kitchen.plural'))
        @slot('active', request()->routeIs('*kitchens*') || request()->routeIs('*requests*'))
        @slot('icon', 'fas fa-store-alt')
        @slot('badge', count_formatted(\App\Models\Kitchen::verified()->count()) ?: null)
        @slot('tree', [
            [
                'name' => trans('kitchen.plural'),
                'url' => route('dashboard.kitchens.index'),
                'can' => ['ability' => 'viewAny', 'model' => \App\Models\Kitchen::class],
                'active' => request()->routeIs('*kitchens*') && !request()->routeIs('*kitchens.requests*'),
            ],
            [
                'name' => trans('kitchen.requests'),
                'url' => route('dashboard.kitchens.requests.index'),
                'can' => ['ability' => 'viewAny', 'model' => \App\Models\Kitchen::class],
                'active' => request()->routeIs('*kitchens.requests*'),
                'badge' => count_formatted(\App\Models\Kitchen::verified()->count()) ?: null
            ]
        ])
    @endcomponent
@endif
