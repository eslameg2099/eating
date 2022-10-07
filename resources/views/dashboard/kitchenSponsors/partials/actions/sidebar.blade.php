@component('dashboard::components.sidebarItem')
    @slot('can', ['ability' => 'viewAny', 'model' => \App\Models\KitchenDuration::class])
    @slot('url', route('dashboard.kitchenDurations.index'))
    @slot('name', trans('kitchensponsor.plural'))
    @slot('active', request()->routeIs('*kitchenDurations*'))
    @slot('icon', 'fab fa-adversal')
    @slot('badge', count_formatted(\App\Models\KitchenDuration::unApproved()->count()) ?: null)
@endcomponent
