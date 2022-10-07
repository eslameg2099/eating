<x-layout :title="$report->id" :breadcrumbs="['dashboard.reports.show', $report]">
    <div class="row">
        <div class="col-md-12">
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')

                <table class="table table-striped table-middle">
                    <tbody>
                    <tr>
                        <th width="200">@lang('reports.attributes.customer')</th>
                        <td>{{ $report->customer->name ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('reports.attributes.kitchen')</th>
                        <td>{{ $report->kitchen->name ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('reports.attributes.read_at')</th>
                        <td>{{ $report->read_at ?: 'X'}}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('reports.attributes.message')</th>
                        <td>{{ $report->message }}</td>
                    </tr>
                    </tbody>
                </table>

                @slot('footer')
{{--                    @include('dashboard.reports.partials.actions.delete')--}}
{{--                    @include('dashboard.reports.partials.actions.restore')--}}
{{--                    @include('dashboard.reports.partials.actions.forceDelete')--}}
                @endslot
            @endcomponent
        </div>
    </div>
</x-layout>
