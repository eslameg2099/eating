<x-layout :title="trans('specialOrders.plural')" :breadcrumbs="['dashboard.specialOrders.index']">
    @include('dashboard.orders.specialOrders.partials.filter')

    @component('dashboard::components.table-box')

        @slot('title')
            @lang('orders.actions.list') ({{ count_formatted($special_orders->total()) }})
        @endslot

        <thead>
        <tr>
            <th>@lang('specialOrders.attributes.id')</th>
            <th>@lang('specialOrders.attributes.user_id')</th>
            <th class="d-none d-md-table-cell">@lang('specialOrders.attributes.kitchen')</th>
            <th>@lang('specialOrders.attributes.total_cost')</th>
            <th>@lang('specialOrders.attributes.status')</th>
            <th>@lang('specialOrders.attributes.created_at')</th>
            <th style="width: 160px">@lang('specialOrders.attributes.operations')</th>
        </tr>
        </thead>
        <tbody>
        @forelse($special_orders as $special_order)
            <tr>
                <td>
                    {{ $special_order->id }}
                </td>
                <td>
                    <a href="{{ route('dashboard.customers.show', $special_order->customer) }}"
                       class="text-decoration-none text-ellipsis">
                        {{ $special_order->customer->name }}
                    </a>
                </td>

                <td class="d-none d-md-table-cell">
                    <a href="{{ route('dashboard.kitchens.show', $special_order->kitchen) }}"
                       class="text-decoration-none text-ellipsis">
                        {{ $special_order->kitchen->name }}
                    </a>
                </td>
                <td>{{ $special_order->cost ?? '--' }}</td>
                <td>{{ $special_order->ReadableStatus() }}</td>
                <td>{{ $special_order->created_at->format('Y-m-d') }}</td>

                <td style="width: 160px">
                    @include('dashboard.orders.specialOrders.partials.actions.show')
                    @include('dashboard.orders.specialOrders.partials.actions.edit')
{{--                    @include('dashboard.orders.specialOrders.partials.actions.delete')--}}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('orders.empty')</td>
            </tr>
        @endforelse

        @if($special_orders->hasPages())
            @slot('footer')
                {{ $special_orders->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>

