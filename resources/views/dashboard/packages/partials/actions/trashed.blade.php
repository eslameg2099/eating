@can('viewAnyTrash', \App\Models\Package::class)
    <a href="{{ route('dashboard.packages.trashed') }}" class="btn btn-outline-danger btn-sm">
        <i class="fas fa fa-fw fa-trash"></i>
        @lang('packages.trashed')
    </a>
@endcan
