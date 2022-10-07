<x-layout :title="$delivery_company->name" :breadcrumbs="['dashboard.delivery_companies.show', $delivery_company]">
    <div class="row">
        <div class="col-md-6">
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')

                <table class="table table-striped table-middle">
                    <tbody>
                    <tr>
                        <th width="200">@lang('delivery_companies.attributes.name')</th>
                        <td>{{ $delivery_company->name }}</td>
                    </tr>
                    </tbody>
                </table>

                @slot('footer')
                    @include('dashboard.delivery_companies.partials.actions.edit')
                    @include('dashboard.delivery_companies.partials.actions.delete')
                    @include('dashboard.delivery_companies.partials.actions.restore')
                    @include('dashboard.delivery_companies.partials.actions.forceDelete')
                @endslot
            @endcomponent
        </div>
    </div>
</x-layout>
