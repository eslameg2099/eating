<x-layout :title="trans('orders.plural')" :breadcrumbs="['dashboard.orders.index']">
    @include('dashboard.orders.idealOrders.partials.filter')

    @component('dashboard::components.table-box')

        @slot('title')
            @lang('orders.actions.list') ({{ count_formatted($orders->total()) }})
        @endslot

        <thead>

        <tr>
            <th>@lang('orders.attributes.id')</th>
            <th>@lang('orders.attributes.user_id')</th>
            <th class="d-none d-md-table-cell">@lang('orders.attributes.kitchen')</th>
            <th>@lang('orders.attributes.total_cost')</th>
            <th>@lang('orders.attributes.status')</th>
            <th>@lang('orders.attributes.created_at')</th>
            <th style="width: 160px">@lang('orders.attributes.operations')</th>
        </tr>
        </thead>
        <tbody>
        @forelse($orders as $order)
            <tr>
                <td>
                    {{ $order->id }}
                </td>
                <td>
                    <a href="{{ route('dashboard.customers.show', $order->customer) }}"
                       class="text-decoration-none text-ellipsis">
                        {{ $order->customer->name }}
                    </a>
                </td>

                <td class="d-none d-md-table-cell">
                    <a href="{{ route('dashboard.kitchens.show', $order->kitchen) }}"
                       class="text-decoration-none text-ellipsis">
                        {{ $order->kitchen->name }}
                    </a>
                </td>
                <td>{{ $order->total_cost }}</td>
                <td>{{ $order->ReadableStatus() }}</td>
                <td>{{ $order->created_at->format('Y-m-d') }}</td>

                <td style="width: 160px">
                    @include('dashboard.orders.idealOrders.partials.actions.show')
                    @include('dashboard.orders.idealOrders.partials.actions.edit')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('orders.empty')</td>
            </tr>
        @endforelse

        @if($orders->hasPages())
            @slot('footer')
                {{ $orders->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>

