@if(method_exists($kitchen, 'trashed') && $kitchen->trashed())
    @can('view', $kitchen)
        <a href="{{ route('dashboard.kitchens.trashed.show', $kitchen) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@else
    @can('view', $kitchen)
        <a href="{{ route('dashboard.kitchens.show', $kitchen) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@endif