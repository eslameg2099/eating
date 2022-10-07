@can('create', \App\Models\DeliveryCompany::class)
    <a href="{{ route('dashboard.delivery_companies.create') }}" class="btn btn-outline-success btn-sm">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('delivery_companies.actions.create')
    </a>
@endcan
