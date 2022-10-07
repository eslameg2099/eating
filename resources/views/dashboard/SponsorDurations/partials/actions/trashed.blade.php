@can('viewAnyTrash', \App\Models\SponsorDurations::class)
    <a href="{{ route('dashboard.sponsorDurations.trashed') }}" class="btn btn-outline-danger btn-sm">
        <i class="fas fa fa-fw fa-trash"></i>
        @lang('sponsorship.trashed')
    </a>
@endcan
