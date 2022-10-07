@can('viewAnyTrash', \App\Models\DeliveryCompany::class)
    <a href="{{ route('dashboard.delivery_companies.trashed') }}" class="btn btn-outline-danger btn-sm">
        <i class="fas fa fa-fw fa-trash"></i>
        @lang('delivery_companies.trashed')
    </a>
@endcan
