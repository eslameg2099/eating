<x-layout :title="trans('orders.plural')" :breadcrumbs="['dashboard.orders.index']">
    @include('dashboard.orders.idealOrders.partials.deliveryFilter')

    @component('dashboard::components.table-box')

        @slot('title')
            <div class="row">
                <div class="col-md-4">@lang('orders.actions.list') ({{ count_formatted($deliveries->total()) }})</div>
                <div class="col-md-4">@lang('orders.delivery.messages.total_cost')  {{ $total_cost }}</div>
                <div class="col-md-4">@lang('orders.delivery.messages.total_profit')  {{ $total_profit }}</div>
            </div>

        @endslot

        <thead>
        <tr>
            <th colspan="100">
                <div class="d-flex">
                    <div class="ml-2 d-flex justify-content-between flex-grow-1">
                        <div>
                            @include('dashboard.orders.idealOrders.partials.actions.excel')
                        </div>
                    </div>
                </div>
            </th>
        </tr>

        <tr>
            <th style="width: 30px;" class="text-center">
                <x-check-all></x-check-all>
            </th>
            <th>@lang('orders.attributes.id')</th>
            <th>@lang('orders.attributes.status')</th>
            <th>@lang('orders.attributes.status')</th>
            <th>@lang('orders.delivery.cost')</th>
            <th>@lang('orders.delivery.delivery_cost')</th>
            <th>@lang('orders.delivery.delivery_company')</th>
            <th>@lang('orders.attributes.created_at')</th>
        </tr>
        </thead>
        <tbody>
        @forelse($deliveries as $delivery)
            <tr>
                <td class="text-center">
                    <x-check-all-item-follow-delivery :model="$delivery"></x-check-all-item-follow-delivery>
                </td>
                <td>
                    <a href="{{ route('dashboard.orders.show', $delivery->order) }}"
                       class="text-decoration-none text-ellipsis">
                        {{ $delivery->order_id }}
                    </a>
                </td>

                <td class="d-none d-md-table-cell">
                    {{ $delivery->status }}
                </td>
                <td>{{ $delivery->message }}</td>
                <td>{{ $delivery->cost }}</td>
                <td>{{ $delivery->order->shipping_cost }}</td>
                <td>{{ $delivery->delivery_company->name }}</td>
                <td>{{ $delivery->created_at->format('Y-m-d') }}</td>

            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('orders.empty')</td>
            </tr>
        @endforelse

        @if($deliveries->hasPages())
            @slot('footer')
                {{ $deliveries->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>

