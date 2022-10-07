@component('dashboard::components.sidebarItem')
    @slot('can', ['ability' => 'viewAny', 'model' => \App\Models\Notification::class])
    @slot('url', route('dashboard.notifications.index'))
    @slot('name', trans('notifications.plural'))
    @slot('active', request()->routeIs('*notifications*'))
    @slot('icon', 'fas fa-envelope')
@endcomponent
