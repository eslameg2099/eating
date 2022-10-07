@can('create', \App\Models\Meal::class)
    <a href="{{ route('dashboard.meals.create') }}" class="btn btn-outline-success btn-sm">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('meal.actions.create')
    </a>
@endcan
