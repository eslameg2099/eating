<x-layout :title="$chef->name" :breadcrumbs="['dashboard.chefs.edit', $chef]">
    {{ BsForm::resource('chefs')->putModel($chef, route('dashboard.chefs.update', $chef), ['files' => true]) }}
    @component('dashboard::components.box')
        @slot('title', trans('chefs.actions.edit'))

        @include('dashboard.accounts.chefs.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('chefs.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>
