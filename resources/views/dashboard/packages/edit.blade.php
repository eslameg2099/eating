<x-layout :title="$package->name" :breadcrumbs="['dashboard.packages.edit', $package]">
    {{ BsForm::resource('packages')->putModel($package, route('dashboard.packages.update', $package)) }}
    @component('dashboard::components.box')
        @slot('title', trans('packages.actions.edit'))

        @include('dashboard.packages.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('packages.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>