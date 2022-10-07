@if(method_exists($kitchen, 'trashed') && $kitchen->trashed())
    @can('view', $kitchen)
        <a href="{{ route('dashboard.kitchens.trashed.requests.show', $kitchen) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@else
    @can('view', $kitchen)
        <a href="{{ route('dashboard.kitchens.requests.show', $kitchen) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@endif
