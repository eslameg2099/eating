@if(method_exists($kitchenDuration, 'trashed') && $kitchenDuration->trashed())
    @can('view', $kitchenDuration)
        <a href="{{ route('dashboard.kitchenDurations.trashed.show', $kitchenDuration) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@else
    @can('view', $kitchenDuration)
        <a href="{{ route('dashboard.kitchenDurations.show', $kitchenDuration) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@endif