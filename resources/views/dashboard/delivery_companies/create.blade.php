<x-layout :title="trans('delivery_companies.actions.create')" :breadcrumbs="['dashboard.delivery_companies.create']">
    {{ BsForm::resource('delivery_companies')->post(route('dashboard.delivery_companies.store')) }}
    @component('dashboard::components.box')
        @slot('title', trans('delivery_companies.actions.create'))

        @include('dashboard.delivery_companies.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('delivery_companies.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>