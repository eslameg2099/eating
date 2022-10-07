<x-layout :title="$city->name" :breadcrumbs="['dashboard.cities.show', $city]">
    <div class="row">
        <div class="col-md-6">
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')

                <table class="table table-striped table-middle">
                    <tbody>
                    <tr>
                        <th width="200">@lang('cities.attributes.name')</th>
                        <td>{{ $city->name }}</td>
                    </tr>
                    </tbody>
                </table>

                @slot('footer')
                    @include('dashboard.cities.partials.actions.edit')
                    @include('dashboard.cities.partials.actions.delete')
                    @include('dashboard.cities.partials.actions.restore')
                    @include('dashboard.cities.partials.actions.forceDelete')
                @endslot
            @endcomponent
        </div>
    </div>
</x-layout>
