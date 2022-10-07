<x-layout :title="trans('chefs.trashed')" :breadcrumbs="['dashboard.chefs.trashed']">
    @include('dashboard.accounts.chefs.partials.filter')

    @component('dashboard::components.table-box')

        @slot('title')
            @lang('chefs.actions.list') ({{ count_formatted($chefs->total()) }})
        @endslot

        <thead>
        <tr>
            <th colspan="100">
                <x-check-all-force-delete
                        type="{{ \App\Models\Chef::class }}"
                        :resource="trans('chefs.plural')"></x-check-all-force-delete>
                <x-check-all-restore
                        type="{{ \App\Models\Chef::class }}"
                        :resource="trans('chefs.plural')"></x-check-all-restore>
            </th>
        </tr>
        <tr>
            <th>
                <x-check-all></x-check-all>
            </th>
            <th>@lang('chefs.attributes.name')</th>
            <th class="d-none d-md-table-cell">@lang('chefs.attributes.email')</th>
            <th>@lang('chefs.attributes.phone')</th>
            <th>@lang('chefs.attributes.created_at')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($chefs as $chef)
            <tr>
                <td>
                    <x-check-all-item :model="$chef"></x-check-all-item>
                </td>
                <td>
                    <a href="{{ route('dashboard.chefs.trashed.show', $chef) }}"
                       class="text-decoration-none text-ellipsis">
                            <span class="index-flag">
                            @include('dashboard.accounts.chefs.partials.flags.svg')
                            </span>
                        <img src="{{ $chef->getAvatar() }}"
                             alt="Product 1"
                             class="img-circle img-size-32 mr-2">
                        {{ $chef->name }}
                    </a>
                </td>

                <td class="d-none d-md-table-cell">
                    {{ $chef->email }}
                </td>
                <td>
                    @include('dashboard.accounts.chefs.partials.flags.phone')
                </td>
                <td>{{ $chef->created_at->format('Y-m-d') }}</td>

                <td style="width: 160px">
                    @include('dashboard.accounts.chefs.partials.actions.show')
                    @include('dashboard.accounts.chefs.partials.actions.restore')
                    @include('dashboard.accounts.chefs.partials.actions.forceDelete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('chefs.empty')</td>
            </tr>
        @endforelse

        @if($chefs->hasPages())
            @slot('footer')
                {{ $chefs->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
