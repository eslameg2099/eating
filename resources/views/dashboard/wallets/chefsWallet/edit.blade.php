<x-layout :title="$order->id" :breadcrumbs="['dashboard.orders.edit', $order]">
    {{ BsForm::resource('orders')->putModel($order, route('dashboard.orders.update', $order), ['files' => true]) }}
    @component('dashboard::components.box')
        @slot('title', trans('orders.actions.edit'))

        @include('dashboard.orders.idealOrders.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('orders.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>
