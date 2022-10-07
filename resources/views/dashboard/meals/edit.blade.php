<x-layout :title="$meal->name" :breadcrumbs="['dashboard.meals.edit', $meal]">
    {{ BsForm::resource('meals')->putModel($meal, route('dashboard.meals.update', $meal), ['files' => true]) }}
    @component('dashboard::components.box')
        @slot('title', trans('meal.actions.edit'))

        @include('dashboard.meals.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('category.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>
