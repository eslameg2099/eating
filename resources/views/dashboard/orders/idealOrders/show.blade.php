<x-layout :title="$order->id" :breadcrumbs="['dashboard.orders.show', $order]">
    @component('dashboard::components.box')
        @slot('bodyClass', 'p-0')

        <table class="table table-striped table-middle">
            <tbody>
            <tr>
                <th width="200">@lang('orders.attributes.id')</th>
                <td>{{ $order->id }}</td>
            </tr>
            <tr>
                <th width="200">@lang('orders.attributes.user_id')</th>
                <td>{{ $order->customer->name ?? '--' }}</td>
            </tr>
            <tr>
                <th width="200">@lang('orders.attributes.chef')</th>
                <td>{{ $order->kitchen->user->name ?? '--' }}</td>
            </tr>
            <tr>
                <th width="200">@lang('orders.attributes.kitchen')</th>
                <td>{{ $order->kitchen->name ?? '--'}}</td>
            </tr>


            <tr>
                <th width="200">@lang('orders.attributes.address')</th>
                <td>{{ $order->address->type ?? '--' }}</td>
            </tr>
            <tr>
                <th width="200">@lang('orders.attributes.coupon')</th>
                <td>{{ $order->coupon->title ?? '--'}}</td>
            </tr>
            <tr>
                <th width="200">@lang('orders.attributes.discount_value')</th>
                <td>{{ $order->discount_value ?? '--'}}</td>
            </tr>

            <tr>
                <th width="200">@lang('orders.attributes.sub_total')</th>
                <td>{{ $order->sub_total ?? '--' }}</td>
            </tr>
            <tr>
                <th width="200">@lang('orders.attributes.total_cost')</th>
                <td>{{ $order->total_cost ?? '--' }}</td>
            </tr>
            <tr>
                <th width="200">@lang('orders.attributes.discount_percentage')</th>
                <td>{{ $order->discount_percentage ?? '--' }}</td>
            </tr>
            <tr>
                <th width="200">@lang('orders.attributes.system_percentage')</th>
                <td>{{ $order->system_percentage  ?? '--'}} %</td>
            </tr>
            <tr>
                <th width="200">@lang('orders.attributes.system_profit')</th>
                <td>{{ $order->system_profit ?? '--' }}</td>
            </tr>
            <tr>
                <th width="200">@lang('orders.attributes.payment_method')</th>
                <td>{{ $order->ReadablePaymentMethods() }}</td>
            </tr>
            <tr>
                <th width="200">@lang('orders.attributes.shipping_cost')</th>
                <td>{{ $order->shipping_cost ?? '--'}}</td>
            </tr>
            <tr>
                <th width="200">@lang('orders.attributes.status')</th>
                <td>{{ $order->ReadableStatus() ?? '--'}}</td>
            </tr>
            <tr>
                <th width="200">@lang('orders.attributes.created_at')</th>
                <td>{{ $order->created_at ?? '--'}}</td>
            </tr>
            <tr>
                <th width="200">@lang('orders.attributes.cooked_at')</th>
                <td>{{ $order->cooked_at ?? '--'}}</td>
            </tr>
            <tr>
                <th width="200">@lang('orders.attributes.received_at')</th>
                <td>{{ $order->received_at ?? '--'}}</td>
            </tr>
            <tr>
                <th width="200">@lang('orders.attributes.delivered_at')</th>
                <td>{{ $order->delivered_at ?? '--'}}</td>
            </tr>

            </tbody>
        </table>

        @slot('footer')
{{--            @include('dashboard.accounts.admins.partials.actions.edit')--}}
        @endslot
    @endcomponent
</x-layout>
