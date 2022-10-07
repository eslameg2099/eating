<x-layout :title="$package->name" :breadcrumbs="['dashboard.packages.show', $package]">
    <div class="row">
        <div class="col-md-6">
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')

                <table class="table table-striped table-middle">
                    <tbody>
                    <tr>
                        <th width="200">@lang('packages.attributes.name')</th>
                        <td>{{ $package->name }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('packages.attributes.from_kg')</th>
                        <td>{{ $package->from_kg }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('packages.attributes.to_kg')</th>
                        <td>{{ $package->to_kg }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('packages.attributes.cost')</th>
                        <td>{{ $package->cost }}</td>
                    </tr>
                    </tbody>
                </table>

                @slot('footer')
                    @include('dashboard.packages.partials.actions.edit')
                    @include('dashboard.packages.partials.actions.delete')
                    @include('dashboard.packages.partials.actions.restore')
                    @include('dashboard.packages.partials.actions.forceDelete')
                @endslot
            @endcomponent
        </div>
    </div>
</x-layout>
