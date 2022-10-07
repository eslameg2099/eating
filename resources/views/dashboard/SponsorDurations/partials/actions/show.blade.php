@if(method_exists($sponsorDuration, 'trashed') && $sponsorDuration->trashed())
    @can('view', $sponsorDuration)
        <a href="{{ route('dashboard.SponsorDurations.trashed.show', $sponsorDuration) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@else
    @can('view', $sponsorDuration)
        <a href="{{ route('dashboard.sponsorDurations.show', $sponsorDuration) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@endif