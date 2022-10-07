<x-layout :title="$delivery_company->name" :breadcrumbs="['dashboard.delivery_companies.edit', $delivery_company]">
    {{ BsForm::resource('delivery_companies')->putModel($delivery_company, route('dashboard.delivery_companies.update', $delivery_company)) }}
    @component('dashboard::components.box')
        @slot('title', trans('delivery_companies.actions.edit'))

        @include('dashboard.delivery_companies.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('delivery_companies.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>