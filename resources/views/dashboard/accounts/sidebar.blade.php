@if(Gate::allows('viewAny', \App\Models\User::class)
    || Gate::allows('viewAny', \App\Models\Chef::class)
    || Gate::allows('viewAny', \App\Models\Customer::class))
    @component('dashboard::components.sidebarItem')
        @slot('url', '#')
        @slot('name', trans('users.plural'))
        @slot('active', request()->routeIs('*admins.*') || request()->routeIs('*customers*'))
        @slot('icon', 'fas fa-users')
        @slot('tree', [
            [
                'name' => trans('admins.plural'),
                'url' => route('dashboard.admins.index'),
                'can' => ['ability' => 'viewAny', 'model' => \App\Models\Admin::class],
                'active' => request()->routeIs('*admins.*'),
            ],
            [
                'name' => trans('chefs.plural'),
                'url' => route('dashboard.chefs.index'),
                'can' => ['ability' => 'viewAny', 'model' => \App\Models\Chef::class],
                'active' => request()->routeIs('*chefs.*'),
            ],
            [
                'name' => trans('customers.plural'),
                'url' => route('dashboard.customers.index'),
                'can' => ['ability' => 'viewAny', 'model' => \App\Models\Customer::class],
                'active' => request()->routeIs('*customers.*'),
            ],
        ])
    @endcomponent
@endif
