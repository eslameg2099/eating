@can('create', \App\Models\SponsorDurations::class)
    <a href="{{ route('dashboard.sponsorDurations.create') }}" class="btn btn-outline-success btn-sm">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('sponsorship.actions.create')
    </a>
@endcan
