@can('create', \App\Models\Chef::class)
    <a href="{{ route('dashboard.chefs.create', request()->only('type')) }}" class="btn btn-outline-success btn-sm">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('chefs.actions.create')
    </a>
@endcan
