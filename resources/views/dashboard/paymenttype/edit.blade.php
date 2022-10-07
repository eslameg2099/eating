<x-layout :title="$TypePayment->name" :breadcrumbs="['dashboard.types.edit', $TypePayment]">
    {{ BsForm::resource('types')->putModel($TypePayment, route('dashboard.types.update', $TypePayment)) }}
    @component('dashboard::components.box')
        @slot('title', trans('types.actions.edit'))

        @include('dashboard.paymenttype.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('cities.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>