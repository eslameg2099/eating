<x-layout :title="trans('packages.actions.create')" :breadcrumbs="['dashboard.packages.create']">
    {{ BsForm::resource('packages')->post(route('dashboard.packages.store')) }}
    @component('dashboard::components.box')
        @slot('title', trans('packages.actions.create'))

        @include('dashboard.packages.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('packages.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>