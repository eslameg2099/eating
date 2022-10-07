<x-layout :title="trans('category.actions.create')" :breadcrumbs="['dashboard.categories.create']">
    {{ BsForm::resource('categories')->post(route('dashboard.categories.store')) }}
    @component('dashboard::components.box')
        @slot('title', trans('category.actions.create'))

        @include('dashboard.categories.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('category.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>