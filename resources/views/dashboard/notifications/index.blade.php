<x-layout :title="trans('notifications.plural')" :breadcrumbs="['dashboard.notifications.index']">
    {{ BsForm::resource('notifications')->post(route('dashboard.notifications.store')) }}
    @component('dashboard::components.box')
        @slot('title', trans('notifications.actions.create'))

        @include('dashboard.notifications.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('notifications.actions.save')) }}
        <hr>
        <button type="button" class="btn btn-secondary" onclick="window.location='{{ route("dashboard.notifications.certain") }}'">{{trans('notifications.actions.certain')}}</button>
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>