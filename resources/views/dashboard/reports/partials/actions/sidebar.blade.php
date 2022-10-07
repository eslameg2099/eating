@component('dashboard::components.sidebarItem')
    @slot('can', ['ability' => 'viewAny', 'model' => \App\Models\Report::class])
    @slot('url', route('dashboard.reports.index'))
    @slot('name', trans('reports.plural'))
    @slot('active', request()->routeIs('*reports*'))
    @slot('icon', 'fas fa-envelope')
    @slot('badge', count_formatted(\App\Models\Report::unread()->count()) ?: null)
@endcomponent
