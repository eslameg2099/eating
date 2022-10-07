@if(method_exists($meal, 'trashed') && $meal->trashed())
    @can('view', $meal)
        <a href="{{ route('dashboard.meals.trashed.show', $meal) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@else
    @can('view', $meal)
        <a href="{{ route('dashboard.meals.show', $meal) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@endif