@if($delivery_company)
    @if(method_exists($delivery_company, 'trashed') && $delivery_company->trashed())
        <a href="{{ route('dashboard.delivery_companies.trashed.show', $delivery_company) }}" class="text-decoration-none text-ellipsis">
            {{ $delivery_company->name }}
        </a>
    @else
        <a href="{{ route('dashboard.delivery_companies.show', $delivery_company) }}" class="text-decoration-none text-ellipsis">
            {{ $delivery_company->name }}
        </a>
    @endif
@else
    ---
@endif