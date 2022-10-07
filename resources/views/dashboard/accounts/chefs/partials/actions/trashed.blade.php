@can('viewAnyTrash', \App\Models\Chef::class)
    <a href="{{ route('dashboard.chefs.trashed', request()->only('type')) }}" class="btn btn-outline-danger btn-sm">
        <i class="fas fa fa-fw fa-trash"></i>
        @lang('chefs.trashed')
    </a>
@endcan
