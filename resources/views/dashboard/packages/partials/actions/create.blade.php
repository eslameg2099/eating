@can('create', \App\Models\Package::class)
    <a href="{{ route('dashboard.packages.create') }}" class="btn btn-outline-success btn-sm">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('packages.actions.create')
    </a>
@endcan
