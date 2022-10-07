<x-layout :title="trans('chefs.actions.create')" :breadcrumbs="['dashboard.chefs.create']">
    {{ BsForm::resource('chefs')->post(route('dashboard.chefs.store')) }}
    @component('dashboard::components.box')
        @slot('title', trans('chefs.actions.create'))

        @include('dashboard.accounts.chefs.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('chefs.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>
