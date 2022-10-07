<x-layout :title="$specialOrder->id" :breadcrumbs="['dashboard.specialOrders.show', $specialOrder]">
    @component('dashboard::components.box')
        @slot('bodyClass', 'p-0')

        <table class="table table-striped table-middle">
            <tbody>
            <tr>
                <th width="200">@lang('specialOrders.attributes.id')</th>
                <td>{{ $specialOrder->id }}</td>
            </tr>
            <tr>
                <th width="200">@lang('specialOrders.attributes.user')</th>
                <td>{{ $specialOrder->customer->name }}</td>
            </tr>
            <tr>
                <th width="200">@lang('specialOrders.attributes.chef')</th>
                <td>{{ $specialOrder->kitchen->user->name }}</td>
            </tr>
            <tr>
                <th width="200">@lang('specialOrders.attributes.kitchen')</th>
                <td>{{ $specialOrder->kitchen->name }}</td>
            </tr>
            <tr>
                <th width="200">@lang('specialOrders.attributes.address')</th>
                <td>{{ $specialOrder->address->type }}</td>
            </tr>
            <tr>
                <th width="200">@lang('specialOrders.attributes.total_cost')</th>
                <td>{{ $specialOrder->cost }}</td>
            </tr>
            <tr>
                <th width="200">@lang('specialOrders.attributes.status')</th>
                <td>{{ $specialOrder->ReadableStatus() }}</td>
            </tr>
            <tr>
                <th width="200">@lang('specialOrders.attributes.payment_method')</th>
                <td>{{ $specialOrder->ReadablePaymentMethods() }}</td>
            </tr>
            <tr>
                <th width="200">@lang('specialOrders.attributes.information')</th>
                <td>{{ $specialOrder->information }}</td>
            </tr>



            </tbody>
        </table>

        @slot('footer')
{{--            @include('dashboard.accounts.admins.partials.actions.edit')--}}
{{--            @include('dashboard.accounts.admins.partials.actions.delete')--}}
{{--            @include('dashboard.accounts.admins.partials.actions.restore')--}}
{{--            @include('dashboard.accounts.admins.partials.actions.forceDelete')--}}
        @endslot
    @endcomponent
</x-layout>
