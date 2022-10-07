<x-layout :title="trans('reports.plural')" :breadcrumbs="['dashboard.reports.index']">
    @include('dashboard.reports.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('reports.actions.list') ({{ count_formatted($reports->total()) }})
        @endslot

        <thead>
        <tr>
            <th colspan="100">
                <div class="d-flex">
{{--                    <x-check-all-delete--}}
{{--                            type="{{ \App\Models\Report::class }}"--}}
{{--                            :resource="trans('reports.plural')"></x-check-all-delete>--}}
                    <div class="ml-2 d-flex justify-content-between flex-grow-1">
                        <div>
                            @include('dashboard.reports.partials.actions.read')
                        </div>
{{--                        @include('dashboard.reports.partials.actions.trashed')--}}
                    </div>
                </div>
            </th>
        </tr>
        <tr>
            <th>
                <x-check-all></x-check-all>
            </th>
            <th>@lang('reports.attributes.order')</th>
            <th>@lang('reports.attributes.customer')</th>
            <th>@lang('reports.attributes.chef')</th>
            <th>@lang('reports.attributes.kitchen')</th>
            <th>@lang('reports.attributes.message')</th>
            <th>@lang('reports.attributes.read_at')</th>
            <th>@lang('reports.attributes.created_at')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($reports as $report)
            <tr class="{{ $report->read() ? 'tw-bg-gray-300' : 'font-weight-bold tw-bg-gray-100' }}">
                <td>
                    <x-check-all-item :model="$report"></x-check-all-item>
                </td>
                <td>
                   
                        {{ $report->order_id }}
                   
                </td>
                <td>
                        {{ $report->customer->name ?? '--' }}
                    </td>
                <td>
                        {{ $report->chef->name ?? '--' }}
                    </td>
                <td>
                        {{ $report->kitchen->name ?? '--' }}
                    </td>
                <td>{{ Str::limit($report->message, 10) }}</td>
                <td>{{  $report->read_at ?? '--'}}</td>
                <td>{{  $report->created_at ?? '--'}}</td>

                <td style="width: 160px">
                    @include('dashboard.reports.partials.actions.show', ['report' => $report])
{{--                    @include('dashboard.reports.partials.actions.delete', ['report' => $report])--}}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('reports.empty')</td>
            </tr>
        @endforelse

        @if($reports->hasPages())
            @slot('footer')
                {{ $reports->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
