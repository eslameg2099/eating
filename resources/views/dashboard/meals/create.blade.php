<x-layout :title="trans('meal.actions.create')" :breadcrumbs="['dashboard.meals.create']">
    {{ BsForm::resource('meals')->post(route('dashboard.meals.store')) }}
    @component('dashboard::components.box')
        @slot('title', trans('meal.actions.create'))

        @include('dashboard.meals.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('meal.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>