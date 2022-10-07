@can('viewAnyTrash', \App\Models\Meal::class)
    <a href="{{ route('dashboard.meals.trashed') }}" class="btn btn-outline-danger btn-sm">
        <i class="fas fa fa-fw fa-trash"></i>
        @lang('meal.trashed')
    </a>
@endcan
