<x-layout :title="trans('sponsorship.actions.create')" :breadcrumbs="['dashboard.sponsorDurations.create']">
    {{ BsForm::resource('categories')->post(route('dashboard.sponsorDurations.store')) }}
    @component('dashboard::components.box')
        @slot('title', trans('sponsorship.actions.create'))

        @include('dashboard.SponsorDurations.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('sponsorship.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>