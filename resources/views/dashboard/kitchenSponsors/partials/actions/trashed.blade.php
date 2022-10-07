@can('viewAnyTrash', \App\Models\Category::class)
    <a href="{{ route('dashboard.categories.trashed') }}" class="btn btn-outline-danger btn-sm">
        <i class="fas fa fa-fw fa-trash"></i>
        @lang('category.trashed')
    </a>
@endcan
