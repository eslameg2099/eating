<x-layout :title="trans('kitchensponsor.plural')" :breadcrumbs="['dashboard.kitchenDurations.index']">
    @include('dashboard.kitchenSponsors.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('kitchensponsor.actions.list') ({{ count_formatted($kitchenDurations->total()) }})
        @endslot

        <thead>
        <tr>
            <th colspan="100">
                <div class="d-flex">
                    <x-check-all-delete
                            type="{{ \App\Models\KitchenDuration::class }}"
                            :resource="trans('kitchensponsor.plural')"></x-check-all-delete>
                    <x-check-all-accept-sponsor
                            type="{{ \App\Models\KitchenDuration::class }}"
                            :resource="trans('kitchensponsor.plural')"></x-check-all-accept-sponsor>
{{--                    <div class="ml-2 d-flex justify-content-between flex-grow-1">--}}
{{--                        <div>--}}
{{--                            @include('dashboard.kitchenSponsors.partials.actions.create')--}}
{{--                        </div>--}}
{{--                        @include('dashboard.kitchenSponsors.partials.actions.trashed')--}}
{{--                    </div>--}}
                </div>
            </th>
        </tr>
        <tr>
            <th>
                <x-check-all></x-check-all>
            </th>
            <th>@lang('kitchensponsor.attributes.sponsor_title')</th>
            <th>@lang('kitchensponsor.attributes.kitchen_name')</th>
            <th>@lang('kitchensponsor.attributes.chef_name')</th>
            <th>@lang('kitchensponsor.attributes.start_date')</th>
            <th>@lang('kitchensponsor.attributes.end_date')</th>
            <th>@lang('kitchensponsor.attributes.created_at')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($kitchenDurations as $kitchenDuration)
            <tr>
                <td>
                    <x-check-all-item :model="$kitchenDuration"></x-check-all-item>
                </td>
                <td>
                    @if($kitchenDuration->kitchenSponsor->first()->getFirstMediaUrl() != null)
                    <img src="{{ $kitchenDuration->kitchenSponsor->first()->getFirstMediaUrl()  }}"
                         alt="*"
                         class="img-circle img-size-32 mr-2">

                    <a href="{{ route('dashboard.kitchenDurations.show', $kitchenDuration) }}"
                       class="text-decoration-none text-ellipsis">
                        {{ $kitchenDuration->kitchenSponsor->last()->sponsor_duration->title }}
                    </a>
                       @endif   
                </td>
                <td>{{ $kitchenDuration->kitchen->name }}</td>
                <td>{{ $kitchenDuration->kitchen->user->name }}</td>
                <td>{{ $kitchenDuration->start_date ?? '--' }}</td>
                <td>{{ $kitchenDuration->end_date ?? '--' }}</td>
                <td>{{ $kitchenDuration->created_at }}</td>
                <td style="width: 160px">
                    @include('dashboard.kitchenSponsors.partials.actions.show', ['kitchenDuration' => $kitchenDuration])
                    @include('dashboard.kitchenSponsors.partials.actions.edit', ['kitchenDuration' => $kitchenDuration])
                    @include('dashboard.kitchenSponsors.partials.actions.accept')
                    {{--@include('dashboard.kitchenSponsors.partials.actions.delete', ['kitchenDuration' => $kitchenDuration])--}}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('kitchensponsor.empty')</td>
            </tr>
        @endforelse

        @if($kitchenDurations->hasPages())
            @slot('footer')
                {{ $kitchenDurations->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
