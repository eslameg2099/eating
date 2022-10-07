@can('create', \App\Models\Kitchen::class)
    <a href="{{ route('dashboard.kitchens.create') }}" class="btn btn-outline-success btn-sm">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('kitchen.actions.create')
    </a>
@endcan
