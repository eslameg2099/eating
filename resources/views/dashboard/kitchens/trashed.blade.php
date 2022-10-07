<x-layout :title="trans('kitchen.trashed')" :breadcrumbs="['dashboard.kitchens.trashed']">
    @include('dashboard.kitchens.partials.filter')

    @component('dashboard::components.table-box')

        @slot('title')
            @lang('kitchen.actions.list') ({{ count_formatted($kitchens->total()) }})
        @endslot

        <thead>
        <tr>
            <th colspan="100">
                <x-check-all-force-delete
                        type="{{ \App\Models\Kitchen::class }}"
                        :resource="trans('kitchen.plural')"></x-check-all-force-delete>
                <x-check-all-restore
                        type="{{ \App\Models\Kitchen::class }}"
                        :resource="trans('kitchen.plural')"></x-check-all-restore>
            </th>
        </tr>
        <tr>
            <th>
                <x-check-all></x-check-all>
            </th>
            <th>@lang('kitchen.attributes.name')</th>
            <th class="d-none d-md-table-cell">@lang('kitchen.attributes.chef')</th>
            <th>@lang('kitchen.attributes.address')</th>
            <th>@lang('kitchen.attributes.city_id')</th>
            <th>@lang('kitchen.attributes.rate')</th>
            <th class="d-none d-md-table-cell">@lang('kitchen.attributes.activation')</th>
            <th>@lang('kitchen.attributes.receive-orders')</th>
            <th>@lang('kitchen.attributes.receive-special')</th>

            <th style="width: 160px">@lang('kitchen.attributes.operations')</th>
        </tr>
        </thead>
        <tbody>
        @forelse($kitchens as $kitchen)
            <tr>
                <td>
                    <x-check-all-item :model="$kitchen"></x-check-all-item>
                </td>
                <td>
                    <a href="{{ route('dashboard.kitchens.show', $kitchen) }}"
                       class="text-decoration-none text-ellipsis">
                            <span class="index-flag">
                            @include('dashboard.kitchens.partials.flags.svg')
                            </span>
                        <img src="{{ $kitchen->getFirstMediaUrl() }}"
                             class="img-circle img-size-32 mr-2">
                        {{ $kitchen->name }}
                    </a>
                </td>

                <td class="d-none d-md-table-cell">
                    {{ $kitchen->user->name }}
                </td>
                <td>{{ $kitchen->address }}</td>
                <td>{{ $kitchen->city->name }}</td>
                <td><small>{{ $kitchen->rate }}</small><strong>/5</strong></td>
                <td>{{ $kitchen->verified_at ?? '--' }}</td>
                <td>{{ $kitchen->active }}</td>
                <td>{{ $kitchen->active_special }}</td>


                <td style="width: 160px">
{{--                    @include('dashboard.kitchens.partials.actions.show')--}}
                    @include('dashboard.kitchens.partials.actions.restore')
                    @include('dashboard.kitchens.partials.actions.forceDelete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('kitchen.empty')</td>
            </tr>
        @endforelse

        @if($kitchens->hasPages())
            @slot('footer')
                {{ $kitchens->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
