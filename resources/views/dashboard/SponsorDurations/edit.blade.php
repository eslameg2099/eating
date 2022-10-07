<x-layout :title="$sponsorDuration->title" :breadcrumbs="['dashboard.sponsorDurations.edit', $sponsorDuration]">
    {{ BsForm::resource('sponsorDurations')->putModel($sponsorDuration, route('dashboard.sponsorDurations.update', $sponsorDuration), ['files' => true]) }}
    @component('dashboard::components.box')
        @slot('title', trans('kitchensponsor.actions.edit'))

        @include('dashboard.SponsorDurations.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('sponsorship.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>
