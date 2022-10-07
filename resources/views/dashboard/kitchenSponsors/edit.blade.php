<x-layout :title="$kitchenDuration->title" :breadcrumbs="['dashboard.kitchenDurations.edit', $kitchenDuration]">
    {{ BsForm::resource('kitchenDurations')->putModel($kitchenDuration, route('dashboard.kitchenDurations.update', $kitchenDuration), ['files' => true]) }}
    @component('dashboard::components.box')
        @slot('title', trans('kitchensponsor.actions.edit'))

        @include('dashboard.kitchenSponsors.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('kitchensponsor.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>
