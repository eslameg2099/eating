@can('viewAnyTrash', \App\Models\Kitchen::class)
    <a href="{{ route('dashboard.kitchens.trashed')}}" class="btn btn-outline-danger btn-sm">
        <i class="fas fa fa-fw fa-trash"></i>
        @lang('kitchen.trashed')
    </a>
@endcan
