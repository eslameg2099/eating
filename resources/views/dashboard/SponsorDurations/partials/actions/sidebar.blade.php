@component('dashboard::components.sidebarItem')
    @slot('can', ['ability' => 'viewAny', 'model' => \App\Models\SponsorDurations::class])
    @slot('url', route('dashboard.sponsorDurations.index'))
    @slot('name', trans('sponsorship.plural'))
    @slot('active', request()->routeIs('*sponsorDurations*'))
    @slot('icon', 'fas fa-paper-plane')
@endcomponent
