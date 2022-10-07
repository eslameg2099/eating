<x-layout :title="$specialOrder->name" :breadcrumbs="['dashboard.specialOrders.edit', $specialOrder]">
    {{ BsForm::resource('specialOrders')->putModel($specialOrder, route('dashboard.specialOrders.update', $specialOrder), ['files' => true]) }}
    @component('dashboard::components.box')
        @slot('title', trans('specialOrders.actions.edit'))

        @include('dashboard.orders.specialOrders.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('specialOrders.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>
