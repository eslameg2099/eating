@if(method_exists($delivery_company, 'trashed') && $delivery_company->trashed())
    @can('view', $delivery_company)
        <a href="{{ route('dashboard.delivery_companies.trashed.show', $delivery_company) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@else
    @can('view', $delivery_company)
        <a href="{{ route('dashboard.delivery_companies.show', $delivery_company) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@endif