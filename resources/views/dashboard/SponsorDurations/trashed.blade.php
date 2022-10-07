<x-layout :title="trans('sponsorship.trashed')" :breadcrumbs="['dashboard.sponsorDurations.trashed']">
    @include('dashboard.SponsorDurations.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('sponsorship.actions.list') ({{ count_formatted($sponsorDurations->total()) }})
        @endslot

        <thead>
        <tr>
            <th colspan="100">
                <div class="d-flex">
                    <div class="ml-2">
                        <x-check-all-restore
                                type="{{ \App\Models\sponsorDurations::class }}"
                                :resource="trans('sponsorship.plural')"></x-check-all-restore>
                    </div>
                </div>
            </th>
        </tr>
        <tr>
            <th>
                <x-check-all></x-check-all>
            </th>
            <th>@lang('sponsorship.attributes.title')</th>
            <th>@lang('sponsorship.attributes.duration')</th>
            <th>@lang('sponsorship.attributes.cost')</th>
            <th>@lang('sponsorship.attributes.currency')</th>
            <th>@lang('sponsorship.attributes.created_at')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($sponsorDurations as $sponsorDuration)
            <tr>
                <td>
                    <x-check-all-item :model="$sponsorDuration"></x-check-all-item>
                </td>
                <td>{{ $sponsorDuration->title }}</td>
                <td>{{ $sponsorDuration->duration . ' ' . $sponsorDuration->duration_type }}</td>
                <td>{{ $sponsorDuration->cost ?? '--' }}</td>
                <td>{{ $sponsorDuration->currency ?? '--' }}</td>
                <td>{{ $sponsorDuration->created_at }}</td>
                <td style="width: 160px">
{{--                    @include('dashboard.SponsorDurations.partials.actions.show', ['sponsorDuration' => $sponsorDuration])--}}
                    @include('dashboard.SponsorDurations.partials.actions.restore', ['sponsorDuration' => $sponsorDuration])
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('sponsorship.empty')</td>
            </tr>
            @endforelse

            @if($sponsorDurations->hasPages())
                @slot('footer')
                    {{ $sponsorDurations->links() }}
                @endslot
            @endif
    @endcomponent
</x-layout>
