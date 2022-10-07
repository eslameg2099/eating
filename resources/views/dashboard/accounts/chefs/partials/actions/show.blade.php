@if(method_exists($chef, 'trashed') && $chef->trashed())
    @can('view', $chef)
        <a href="{{ route('dashboard.chefs.trashed.show', $chef) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@else
    @can('view', $chef)
        <a href="{{ route('dashboard.chefs.show', $chef) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@endif
