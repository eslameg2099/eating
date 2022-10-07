<x-layout :title="$kitchen->name" :breadcrumbs="['dashboard.kitchens.edit', $kitchen]">
    {{ BsForm::resource('kitchen')->putModel($kitchen, route('dashboard.kitchens.update', $kitchen), ['files' => true]) }}
    @component('dashboard::components.box')
        @slot('title', trans('kitchen.actions.edit'))

        @include('dashboard.kitchens.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('kitchen.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>
