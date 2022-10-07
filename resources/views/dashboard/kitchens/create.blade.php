<x-layout :title="trans('kitchen.actions.create')" :breadcrumbs="['dashboard.kitchens.create']">
    {{ BsForm::resource('kitchen')->post(route('dashboard.kitchens.store')) }}
    @component('dashboard::components.box')
        @slot('title', trans('kitchen.actions.create'))

        @include('dashboard.kitchens.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('kitchen.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>