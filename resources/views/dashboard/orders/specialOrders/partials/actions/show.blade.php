@if(method_exists($special_order, 'trashed') && $special_order->trashed())
    @can('view', $special_order)
        <a href="{{ route('dashboard.specialOrders.trashed.show', $special_order) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@else
    @can('view', $special_order)
        <a href="{{ route('dashboard.specialOrders.show', $special_order) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@endif